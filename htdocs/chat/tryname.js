document.addEventListener("DOMContentLoaded", function(){
    const   //content =   document.querySelector("#modal-user .modal-content"),
        //header  =   content.querySelector(".modal-header"),
        // body    =   content.querySelector(".modal-body"),
        //userNameDis =   header.querySelector("#modal-user-usernamedisplay"),
        form_tryUsername   =   document.getElementById("form-modal-tryusername")
        ;

    form_tryUsername.onsubmit = (v)=>{
        v.preventDefault();

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/request/chat/tryname.php", true);
        xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let res = xhr.response;
                    if((/success/).test(res)){
                        form_tryUsername.querySelector("input[name='newName']").value = '';
                        document.getElementById('modal-user-usernamedisplay').innerText = res.substring(res.indexOf(' ') + 1);
                    }else if((/fail/).test(res)){
                        alert(res);
                    }
                }
            }
        };

        let formdata = new FormData(form_tryUsername);//libary obj, takes html form ele.
        //formdata.append('',/&ep;);
        xhr.send(formdata);//send form data to php
    }
});