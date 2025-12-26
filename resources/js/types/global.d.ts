import { PageProps as InertiaPageProps } from '@inertiajs/core';
import { AxiosInstance } from 'axios';
import type { RouteParam, Config } from 'ziggy-js';
import { PageProps as AppPageProps } from '.';

// -----------------------------
// GLOBAL WINDOW + ROUTE
// -----------------------------
declare global {
    interface Window {
        axios: AxiosInstance;
    }

    var route: {
        (): {
            current: (name: string) => boolean;
        };
        (name: string, params?: RouteParam | RouteParam[], absolute?: boolean, config?: Config): string;
    };
}

// -----------------------------
// VUE INSTANCE PROPERTIES
// -----------------------------
declare module 'vue' {
    interface ComponentCustomProperties {
        route: {
            (name: string, params?: import('ziggy-js').RouteParam | import('ziggy-js').RouteParam[], absolute?: boolean, config?: import('ziggy-js').Config): string;
            (): {
                current: (name: string) => boolean;
            };
        };
        $page: import('@inertiajs/core').Page<InertiaPageProps & AppPageProps>;
    }
}

// -----------------------------
// INERTIA PAGE PROPS MERGE
// -----------------------------
declare module '@inertiajs/core' {
    interface PageProps extends InertiaPageProps, AppPageProps {}
}
