document.addEventListener("DOMContentLoaded", function(){
    const   form    = document.getElementById("form-usersearch");
            // input   = form.querySelector("input[name='searchTerm']");

    form.onsubmit = (v)=>{
        v.preventDefault();//maybe
        
        let fd = new FormData(form);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", '/request/chat/searchUsers.php', true);
        xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    console.log(xhr.response);
                }
            }
        };
        xhr.send(fd);
    }
}