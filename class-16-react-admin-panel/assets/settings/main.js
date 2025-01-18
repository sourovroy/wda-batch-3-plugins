import domReady from '@wordpress/dom-ready';
import { createRoot } from '@wordpress/element';
import { RouterProvider } from "react-router-dom";

import router from './router';

domReady(() => {
    const root = createRoot( document.getElementById('react-admin-settings-app') );

    root.render( <RouterProvider router={router} /> );
});
