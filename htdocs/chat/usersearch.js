document.addEventListener("DOMContentLoaded", function(){
    const   form_srch   = document.getElementById("form-usersearch"),
        nameDisplay     = document.getElementById("modal-user-usernamedisplay"),
        form_tryUsername    = document.getElementById("form-modal-tryusername"),
        paginationBottom_ul = document.getElementById("paginationBottom"),
        rndName_btn     = document.getElementById("rndName_btn"),
        form_decpt      = document.getElementById("form-modal-description"),
        decpt_txt       = document.getElementById("usr_description"),
        decpt_btn       = document.getElementById("btn_description"),
        usercard_container  = document.getElementById("usercards"),
        usercard_templet    = document.querySelector(".card").cloneNode(true)
        ;

    usercard_templet.removeAttribute('hidden');
    usercard_container.innerHTML = '';
    
    //////////////////////////////////////////////////
    //search request
    //////////////////////////////////////////////////
    form_srch.onsubmit = (v)=>{
        v.preventDefault();//maybe
        let fd = new FormData(form_srch);
            fd.append('pgnum', 0);

        let xhr = new XMLHttpRequest();
        xhr.open("POST", '/request/chat/searchUsers.php', true);
        xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    usercard_container.innerHTML = '';

                    data = JSON.parse(xhr.response);
                    for(const val of data.values()){
                        crd = usercard_templet.cloneNode(true);
                        crd.querySelector(".card-title").innerText = val['username'];
                        crd.querySelector("small.text-left").innerText = val['creationtime'];
                        crd.querySelector("small.text-right").innerText = val['lastactivetime'];
                        crd.querySelector(".card-text").innerText = val['description'];
                        usercard_container.appendChild(crd);
                    }
                    /* 
                    <div hidden class="card" style="max-width: 100%; min-width: 200px;">
                        <img class="card-img-top rounded-0" src="/icon/default/icon.png">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">description</p>
                            <div class="justify-content-between">
                                <small class="text-muted text-left">join#</small>
                                <small class="text-muted text-right">onlinehr#</small>
                            </div>
                        </div>
                    </div>
                    */
                }
            }
        };
        xhr.send(fd);
    }

    //////////////////////////////////////////////////
    //page number handling
    //////////////////////////////////////////////////

    //////////////////////////////////////////////////
    //try new name
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
    //set description
    //////////////////////////////////////////////////
    decpt_btn.setAttribute("hidden","");
    if (decpt_txt.addEventListener) {
        decpt_txt.addEventListener('input', function() {
            decpt_btn.removeAttribute("hidden");
        }, false);
    } else if (area.attachEvent) {
        decpt_txt.attachEvent('onpropertychange', function() {
            decpt_btn.removeAttribute("hidden");
        });
    }

    form_decpt.addEventListener("submit", ()=>{
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/request/chat/setUsrDescription.php", true);
        xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
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