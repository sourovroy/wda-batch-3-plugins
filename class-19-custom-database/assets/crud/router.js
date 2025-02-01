import { createHashRouter } from "react-router-dom";

import App from './components/App';
import List from './components/List';
import Create from './components/Create';
import Edit from './components/Edit';

const router = createHashRouter([
    {
        path: "/",
        element: <App />,
        children: [
            {
                path: "",
                element: <List />
            },
            {
                path: "/create",
                element: <Create />
            },
            {
                path: "/edit/:postId",
                element: <Edit />
            }
        ],
    },
]);

export default router;
