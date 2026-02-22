function profileDropdown(){

    const button = document.getElementById('profileButton');
    const dropdown = document.getElementById('profileDropdown');

    button.addEventListener('click', function (){
        dropdown.classList.toggle('hidden');
    });

    document.addEventListener('click', function(event){
        if(!button.contains(event.target) && !dropdown.containt(event.target)){
            dropdown.classList.add('hidden');
        }
    });
}


document.addEventListener("DOMContentLoaded", () =>{
    profileDropdown();
})