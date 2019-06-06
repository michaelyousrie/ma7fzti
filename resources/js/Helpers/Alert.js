import Swal from "sweetalert2";

function msg( title, text = title, className = 'success' ) 
{
    Swal.fire({
        title: title,
        text: text,
        type: className,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500
    })
}

function error( title, text = title, className = 'error' )
{
    Swal.fire({
        title: title,
        text: text,
        type: className,
        position: 'top-end'
    })
}

function confirm( text, successCallback, cancelCallback = null, title = "Sure ?" )
{
    Swal.fire({
        title: title,
        text: text,
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes!',
        cancelButtonText: 'No!',
    }).then(result => {
        if ( result.value ) successCallback();

        if ( typeof cancelCallback == "function" ) {
            cancelCallback();
        } else {
            return false;
        }
    });
}

export {
    msg, error, confirm
}
