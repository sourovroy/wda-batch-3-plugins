import { useEffect, useState } from 'react';

function General() {
    const [ formValue, setFormValue ] = useState({
        select_checkbox: [],
    });

    const onFormSubmit = (event) => {
        event.preventDefault();
        let formdata = new FormData(event.target);

        formdata.append( 'action', 'react_form_submit' );
        formdata.append( 'nonce', ReactSettings.nonce );

        fetch( ReactSettings.ajax_url, {
            method: "POST",
            body: formdata,
        } );
    };

    useEffect(() => {
        let url = ReactSettings.ajax_url + "?action=react_get_form_data&nonce=" + ReactSettings.nonce;

        fetch( url, {
            method: "GET",
        } ).then((response) => {
            return response.json();
        }).then((response) => {
            setFormValue( response.data );
        });
    }, []);

    const onRadioCheck = (event) => {
        setFormValue({
            ...formValue,
            [ event.target.name ]: event.target.value
        });
    };

    const onCheckboxChange = (event, name) => {
        let checkboxValues = formValue[ name ];

        if ( event.target.checked ) {
            checkboxValues.push( event.target.value );
        } else {
            checkboxValues = checkboxValues.filter((item) => item != event.target.value);
        }

        setFormValue({
            ...formValue,
            [ name ]: checkboxValues,
        });
    };

    return (
        <div>
            <form onSubmit={onFormSubmit}>

                <table class="form-table">
                    <tbody>
                        <tr>
                            <th><label>Title</label></th>
                            <td><input type="text" name="title" defaultValue={formValue.title} /></td>
                        </tr>
                        <tr>
                            <th><label>Choose Option</label></th>
                            <td>
                                <select name="choose_option">
                                    <option value="1" selected={formValue.choose_option == '1'}>1</option>
                                    <option value="2" selected={formValue.choose_option == '2'}>2</option>
                                    <option value="3" selected={formValue.choose_option == '3'}>3</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Radio</th>
                            <td>
                                <fieldset>
                                    <label><input type="radio" name="select_radio" value="1" checked={formValue.select_radio == '1'} onChange={onRadioCheck} /> One</label><br />
                                    <label><input type="radio" name="select_radio" value="2" checked={formValue.select_radio == '2'} onChange={onRadioCheck} /> Two</label><br />
                                    <label><input type="radio" name="select_radio" value="3" checked={formValue.select_radio == '3'} onChange={onRadioCheck} /> Three</label>
                                </fieldset>
                            </td>
                        </tr>
                        <tr>
                            <th>Checkbox</th>
                            <td>
                                <fieldset>
                                    <label><input type="checkbox" name="select_checkbox[]" value="1" checked={formValue.select_checkbox.includes('1')} onChange={e => onCheckboxChange(e, 'select_checkbox')} /> One</label><br />
                                    <label><input type="checkbox" name="select_checkbox[]" value="2" checked={formValue.select_checkbox.includes('2')} onChange={e => onCheckboxChange(e, 'select_checkbox')} /> Two</label><br />
                                    <label><input type="checkbox" name="select_checkbox[]" value="3" checked={formValue.select_checkbox.includes('3')} onChange={e => onCheckboxChange(e, 'select_checkbox')} /> Three</label>
                                </fieldset>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p class="submit">
                    <input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes" />
                </p>
            </form>
        </div>
    );
}

export default General;
