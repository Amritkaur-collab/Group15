function setStatusColor() {
        var select = document.getElementById("status");
        var selectedOption = select.options[select.selectedIndex];
        select.className = ''; 
        select.classList.add(selectedOption.className);
        
}
