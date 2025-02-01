import { useEffect, useState } from 'react';
import { Link } from "react-router-dom";

function List() {

    const [ listData, setListData ] = useState([]);

    const getList = () => {
        let url = ReactSettings.ajax_url + "?action=cd_get_list&nonce=" + ReactSettings.nonce;

        fetch( url, {
            method: "GET",
        } ).then((response) => {
            return response.json();
        }).then((response) => {
            setListData( response.data );
        });
    };

    useEffect(() => {
        getList();
    }, []);

    const onDelete = (postId) => {
        let sure = confirm("Are you sure?");

        if ( sure ) {
            fetch( ReactSettings.ajax_url, {
                method: "POST",
                body: new URLSearchParams({
                    nonce: ReactSettings.nonce,
                    action: 'cd_delete_item',
                    id: postId,
                }),
            } ).then((response) => {
                return response.json();
            }).then((response) => {
                if ( response.success ) {
                    getList();
                }
            });
        }
    };

    return (
        <div className="cd-table-wrapper">
            <table className="wp-list-table widefat fixed striped table-view-list posts">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    {listData.map((item) => (<tr>
                        <td>{item.id}</td>
                        <td>{item.title}</td>
                        <td>{item.created_at}</td>
                        <td>
                            <Link to={"/edit/" + item.id} className="button button-secondary">Edit</Link>
                            &nbsp;
                            <a className="button button-link-delete" onClick={() => onDelete(item.id)}>Delete</a>
                        </td>
                    </tr>))}
                </tbody>
            </table>
        </div>
    );
}

export default List;
