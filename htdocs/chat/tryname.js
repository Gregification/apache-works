const form  =   document.getElementById("modal-user-form"),
    content =   form.querySelector(".modal-content")
    header  =   content.querySelector(".modal-header"),
    body    =   content.querySelector(".modal-body"),
    footer  =   content.querySelector(".modal-footer"),
    userNameDispaly =   header.querySelector(".modal-user-label"),
    tryBtn  =   body.querySelector(".btn"),
    footerStyleDisplay_og  =   footer.style.display;

footer.style.display = "none";
form.onsubmit = (v)=>{
    v.preventDefault();
}

// console.log(content);
// console.log(userNameDispaly);
// console.log(tryBtn);

tryBtn.onclick = () => {
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
    xhr.send();

    footer.style.display = footerStyleDisplay_og;
}