import { Outlet, Link } from "react-router-dom";

function App() {
    return (
        <div className="wrap">
            <div className="cd-header">
                <h1>Database CRUD</h1>
                <Link to="/create" className="button button-primary">Add New Post</Link>
            </div>
            <Outlet />
        </div>
    );
}

export default App;
