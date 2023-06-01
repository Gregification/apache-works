document.addEventListener("DOMContentLoaded", function(){
    const   content =   document.querySelector("#modal-user .modal-content"),
        //header  =   content.querySelector(".modal-header"),
        body    =   content.querySelector(".modal-body"),
        // footer  =   content.querySelector(".modal-footer"),
        //userNameDis =   header.querySelector("#modal-user-usernamedisplay"),
        form_tryUsername   =   body.querySelector("#form-modal-tryusername")
        ;

    //footer.style.display = "none";
    form_tryUsername.onsubmit = (v)=>{
        v.preventDefault();

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/request/chat/tryname.php", true);
        xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let data = xhr.response;
                    if((/success/).test(data)){
                        form_tryUsername.querySelector("input[name='newName']").value = '';
                        console.log('data: ' + data);
                        document.getElementById('modal-user-usernamedisplay').innerText = data.substring(data.indexOf(' ') + 1);
                    }else if((/fail_/).test(data)){
                        alert(data);
                    }else{
                        // alert(data);
                        // console.log('data something else: ' + data);
                    }
                }
            }
        };

        let formdata = new FormData(form_tryUsername);//libary obj, takes html form ele.
        //formdata.append('',/&ep;);
        xhr.send(formdata);//send form data to php
    }
});