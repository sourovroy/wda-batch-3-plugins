import { createHashRouter } from "react-router-dom";

import App from './components/App';
import General from './components/General';
import About from './components/About';

const router = createHashRouter([
    {
        path: "/",
        element: <App />,
        children: [
            {
                path: "",
                element: <General />
            },
            {
                path: "/about",
                element: <About />
            }
        ],
    },
]);

export default router;
