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
        usercard_templet    = usercard_container.querySelector("template").content.querySelector(".card").cloneNode(true) //document.querySelector("#card-template > div.card").cloneNode(true)
        ;
    
    //////////////////////////////////////////////////
    //search request
    //////////////////////////////////////////////////
    /*
    form_srch.onsubmit = (v)=>{
        v.preventDefault();//maybe
        let fd = new FormData(form_srch);
            // fd.append('pgnum', 0);

        let xhr = new XMLHttpRequest();
        xhr.open("GET", '/request/chat/searchUsers.php', true);
        xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    usercard_container.innerHTML = '';
                    let curETime = Date.now()/1000;
                    data = JSON.parse(xhr.response);
                    for(const val of data.values()){
                        crd = usercard_templet.cloneNode(true);
                        
                        crd.querySelector(".card-title").innerText = val['username'];

                        let d = new Date(0);
                        d.setSeconds(val['creationtime']);
                        crd.querySelector("small.text-left").innerText = d.toLocaleDateString() + " | ";

                        crd.querySelector("small.text-right").innerText = (
                            (lat = val['lastactivetime']) <= 0   ? 'online'
                                :   ((curETime - lat)/(36e2)).toFixed(1) + "hr ago"
                        );
                        
                        crd.querySelector(".card-text").innerText = val['description'];
                        
                        usercard_container.appendChild(crd);
                    }
                }
            }
        };
        xhr.send(fd);
    }
    */
    
    let xhr = new XMLHttpRequest();
    xhr.open("GET", '/request/chat/searchUsers.php' + window.location.search, true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                // console.log('params:\n' + window.location.search);
                // console.log('res:\n' + xhr.response);
                let curETime = Date.now()/1000;
                data = JSON.parse(xhr.response);

                for(const val of data.values()){
                    crd = usercard_templet.cloneNode(true);
                    
                    crd.querySelector(".card-title").innerText = val['username'];

                    let d = new Date(0);
                    d.setSeconds(val['creationtime']);
                    crd.querySelector("small.text-left").innerText = d.toLocaleDateString() + " | ";

                    crd.querySelector("small.text-right").innerText = (
                        (lat = val['lastactivetime']) <= 0   ? 'online'
                            :   ((curETime - lat)/(36e2)).toFixed(1) + "hr ago"
                    );
                    
                    crd.querySelector(".card-text").innerText = val['description'];
                    
                    usercard_container.appendChild(crd);
                }
            }
        }
    };
    xhr.send(null);

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