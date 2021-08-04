const inventorys = document.getElementById('inventorys');
if(inventorys){
inventorys.addEventListener('click',e =>{

    if (e.target.className === 'fas fa-trash delete-inventory'){
        if(confirm('Are You Sure you want to delete this Equipement')){
        const id = e.target.getAttribute('data-id');
        fetch('company/inventory/delete/${id}',{
            method:'DELETE'
        }).then(res=> window.location.reload());
    }
}
});


}

function myFunction() {
  alert("I am an alert box!");
}
