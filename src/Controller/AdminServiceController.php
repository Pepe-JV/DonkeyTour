<?php

namespace App\Controller;

use App\Entity\Despedida;
use App\Entity\Donkey;
use App\Entity\Service;
use App\Entity\Sponsorship;
use App\Entity\Therapy;
use App\Entity\Tour;
use App\Form\AdminDespedidaType;
use App\Form\AdminSponsorshipType;
use App\Form\AdminTherapyType;
use App\Form\AdminTourType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/servicios')]
#[IsGranted('ROLE_ADMIN')]
final class AdminServiceController extends AbstractController
{
    private const TYPE_MAP = [
        'tour'        => ['entity' => Tour::class,        'form' => AdminTourType::class,        'label' => 'Tour Guiado'],
        'despedida'   => ['entity' => Despedida::class,    'form' => AdminDespedidaType::class,   'label' => 'Despedida'],
        'therapy'     => ['entity' => Therapy::class,      'form' => AdminTherapyType::class,     'label' => 'Burroterapia'],
        'sponsorship' => ['entity' => Sponsorship::class,  'form' => AdminSponsorshipType::class, 'label' => 'Apadrinamiento'],
    ];

    /* ───── LISTADO ───── */
    #[Route('', name: 'app_admin_service_index', methods: ['GET'])]
    public function index(ServiceRepository $serviceRepository): Response
    {
        $services = $serviceRepository->findBy(['deletedAt' => null], ['createdAt' => 'DESC']);

        return $this->render('admin/service/index.html.twig', [
            'services' => $services,
        ]);
    }

    /* ───── ELEGIR TIPO ───── */
    #[Route('/nuevo', name: 'app_admin_service_choose_type', methods: ['GET'])]
    public function chooseType(): Response
    {
        return $this->render('admin/service/choose_type.html.twig', [
            'types' => self::TYPE_MAP,
        ]);
    }

    /* ───── NUEVO SERVICIO ───── */
    #[Route('/nuevo/{type}', name: 'app_admin_service_new', methods: ['GET', 'POST'])]
    public function new(string $type, Request $request, EntityManagerInterface $em): Response
    {
        if (!isset(self::TYPE_MAP[$type])) {
            throw $this->createNotFoundException('Tipo de servicio no válido.');
        }

        $meta    = self::TYPE_MAP[$type];
        $entity  = new $meta['entity']();
        $form    = $this->createForm($meta['form'], $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entity->setType($meta['label']);
            $entity->setCreatedAt(new \DateTimeImmutable());
            $entity->setUpdatedAt(new \DateTime());

            $em->persist($entity);
            $em->flush();

            $this->addFlash('success', 'Servicio «' . $meta['label'] . '» creado correctamente.');
            return $this->redirectToRoute('app_admin_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/service/new.html.twig', [
            'form'       => $form,
            'type_key'   => $type,
            'type_label' => $meta['label'],
        ]);
    }

    /* ───── VER DETALLE ───── */
    #[Route('/{id}', name: 'app_admin_service_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Service $service): Response
    {
        return $this->render('admin/service/show.html.twig', [
            'service' => $service,
        ]);
    }

    /* ───── EDITAR ───── */
    #[Route('/{id}/editar', name: 'app_admin_service_edit', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function edit(Request $request, Service $service, EntityManagerInterface $em): Response
    {
        $typeKey  = $this->resolveTypeKey($service);
        $formClass = self::TYPE_MAP[$typeKey]['form'] ?? null;

        if (!$formClass) {
            throw $this->createNotFoundException('No se puede editar un servicio base genérico.');
        }

        $form = $this->createForm($formClass, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $service->setUpdatedAt(new \DateTime());
            $em->flush();

            $this->addFlash('success', 'Servicio actualizado correctamente.');
            return $this->redirectToRoute('app_admin_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/service/edit.html.twig', [
            'form'       => $form,
            'service'    => $service,
            'type_label' => self::TYPE_MAP[$typeKey]['label'] ?? $service->getType(),
        ]);
    }

    /* ───── ELIMINAR (soft-delete) ───── */
    #[Route('/{id}', name: 'app_admin_service_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(Request $request, Service $service, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $service->getId(), $request->request->get('_token'))) {
            $service->setDeletedAt(new \DateTime());
            $service->setUpdatedAt(new \DateTime());
            $em->flush();

            $this->addFlash('success', 'Servicio eliminado correctamente.');
        }

        return $this->redirectToRoute('app_admin_service_index', [], Response::HTTP_SEE_OTHER);
    }

    /* ───── Helpers ───── */
    private function resolveTypeKey(Service $service): string
    {
        return match (true) {
            $service instanceof Tour        => 'tour',
            $service instanceof Despedida   => 'despedida',
            $service instanceof Therapy     => 'therapy',
            $service instanceof Sponsorship => 'sponsorship',
            default                         => 'service',
        };
    }
}
