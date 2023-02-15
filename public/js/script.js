const dropdown = document.getElementById('dropdown-ville');
dropdown.addEventListener('change', () => {
    if(dropdown.value == 0){
        window.location.href = `/client`;
        return
    }
    window.location.href = `/client/ville/${dropdown.value}`;
});