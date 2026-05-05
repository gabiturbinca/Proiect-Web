const params = new URLSearchParams(window.location.search);
const categoryId = params.get('gift_id');

//-> asta e API-ul /api/gifts/{id}