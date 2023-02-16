const dropdown = document.getElementById('dropdown-ville');
const dropdownEval = document.querySelectorAll("[id='dropdown-eval']");
dropdown.addEventListener('change', () => {
    if (dropdown.value == 0) {
        window.location.href = `/client`;
        return
    }
    window.location.href = `/client/ville/${dropdown.value}`;
});
for (let i = 0; i < dropdownEval.length; i++) {
    dropdownEval[i].addEventListener('change', () => {
        console.log(dropdownEval.value);
        window.location.href = `/evaluation/${dropdownEval.value}`;
    });
    
}
