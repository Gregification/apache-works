document.addEventListener("DOMContentLoaded", function(){
    const   form_srch   = document.getElementById("form-usersearch"),
        nameDisplay     = document.getElementById("modal-user-usernamedisplay"),
        form_tryUsername    = document.getElementById("form-modal-tryusername"),
        paginationBottom_ul = document.getElementById("paginationBottom"),
        rndName_btn     = document.getElementById("rndName_btn")
        ;

    //////////////////////////////////////////////////
    //search request
    //////////////////////////////////////////////////
    form_srch.onsubmit = (v)=>{
        // v.preventDefault();//maybe    
        let fd = new FormData(form_srch);
            fd.append('batchsize', 'all');
            fd.append('pgnum', 1);

        let xhr = new XMLHttpRequest();
        xhr.open("POST", '/request/chat/searchUsers.php', true);
        xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    console.log('response: ' + xhr.response);
                }
            }
        };
        xhr.send(fd);
    }

    //////////////////////////////////////////////////
    //page number handling
    //////////////////////////////////////////////////

    //////////////////////////////////////////////////
    //try name
    //////////////////////////////////////////////////
    form_tryUsername.addEventListener("submit", (v)=>{
        v.preventDefault();

        let formdata = new FormData(form_tryUsername);
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
        xhr.send(formdata);
    });

    //////////////////////////////////////////////////
    //random name button
    //////////////////////////////////////////////////
    rndName_btn.addEventListener("click",()=>{
        rndName_btn.setAttribute("disabled","");
        rndName_btn.innerHTML = '<div class="spinner-border text-warning" role="status"><span class="sr-only">Loading...</span></div>';
        
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/request/chat/genSetName.php", true);
        xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    // console.log("response: " + xhr.response);
                    nameDisplay.innerText = xhr.response;
                }
            }
            rndName_btn.innerHTML = "random name";
            rndName_btn.removeAttribute("disabled");
        };

        let formdata = new FormData();
        formdata.append('usepreexisting', 0);
        xhr.send(formdata);
    });

});