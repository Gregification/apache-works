const   form_tryUsername   =   document.getElementById("form-modal-tryusername"),
    // content =   form.querySelector(".modal-content")
    // header  =   content.querySelector(".modal-header"),
    // body    =   content.querySelector(".modal-body"),
    // footer  =   content.querySelector(".modal-footer"),
    // userNameDispaly =   header.querySelector(".modal-user-label"),
    tryBtn  =   form_tryUsername.querySelector("button[type='submit']")
    //footerStyleDisplay_og  =   footer.style.display
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
                console.log(data);
            }
        }
    };

    let formdata = new FormData(form_tryUsername);//libary obj, takes html form ele.
    formdata.append('oldName', );
    xhr.send(formdata);//send form data to php
}

tryBtn.onclick = () => {

    //footer.style.display = footerStyleDisplay_og;
}