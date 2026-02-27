import React from 'react';
import ReactDOM from 'react-dom/client';
import ServiceFilter from './components/ServiceFilter';
import DonkeyCarousel from './components/DonkeyCarousel';
import { CounterGroup } from './components/AnimatedCounter';
import BackToTop from './components/BackToTop';

// Almacenar roots activos para limpieza con Turbo
const activeRoots = new Map();

/**
 * Monta un componente React en un elemento del DOM si existe.
 * Desmonta el root anterior si ya existía (necesario para Turbo).
 */
function mountIfExists(elementId, Component) {
    const el = document.getElementById(elementId);
    if (!el) return;

    // Desmontar root anterior si existe
    if (activeRoots.has(elementId)) {
        try { activeRoots.get(elementId).unmount(); } catch (_) {}
        activeRoots.delete(elementId);
    }

    const root = ReactDOM.createRoot(el);
    root.render(
        <React.StrictMode>
            <Component />
        </React.StrictMode>
    );
    activeRoots.set(elementId, root);
}

/**
 * Monta todos los componentes React en los puntos de montaje disponibles.
 */
function mountAll() {
    mountIfExists('react-service-filter', ServiceFilter);
    mountIfExists('react-donkey-carousel', DonkeyCarousel);
    mountIfExists('react-counters', CounterGroup);
    mountIfExists('react-back-to-top', BackToTop);
}

/**
 * Desmonta todos los componentes React (antes de que Turbo cachee la página).
 */
function unmountAll() {
    activeRoots.forEach((root) => {
        try { root.unmount(); } catch (_) {}
    });
    activeRoots.clear();
}

// Limpiar antes de que Turbo cachee la página
document.addEventListener('turbo:before-cache', unmountAll);

// Montar en cada navegación de Turbo (incluido el primer load)
document.addEventListener('turbo:load', mountAll);

// Fallback: si Turbo no está cargado, montar con DOMContentLoaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', mountAll);
} else {
    mountAll();
}

