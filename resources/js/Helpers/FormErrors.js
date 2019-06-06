function Apply( errors ) {
    for ( let key in errors ) {
        if (errors.hasOwnProperty(key)) {
            const value = errors[key];

            $('span#' + key + '-feedback-span').html(value);
        }
    }

    return errors;
}

function Clear() {
    $('.error-feedback-span').html('');
    
    return;
}

function ClearField(fieldId) {
    $('#' + fieldId).siblings('.error-feedback-span').html('');
}

export {
    Apply, Clear, ClearField
}
