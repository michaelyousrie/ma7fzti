function makeUrl(url) {
    return 'api/v1/' + url.replace('/', '') + '?api_token=' + window.api_token;
}

export {
    makeUrl
}
