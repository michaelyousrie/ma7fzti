function Ajax( url, data, method = 'post' ) {
    url = 'api/v1/' + url.replace('/', '') + '?api_token=' + window.api_token;
    
    return window.axios[method](url, data).then(response => {
        return response;
    });
}

export default {
    Ajax
}
