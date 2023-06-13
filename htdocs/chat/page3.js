import { dbcjss_promSessioninfo } from "/request/dbcjss.js";

const form_joinchat         = document.getElementById("form-modal-joinchat"),
    form_messagebox         = document.getElementById("form-messagebox"),
    chatnamedisplays        = Array(
            document.getElementById("chatnamedisplay"),
            document.getElementById("modal-chatinfo-chatnamedisplay")
        ),
    msg_display             = document.getElementById("msgDisplay"),
    msg_template            = msg_display.querySelector("template").content.querySelector("div").cloneNode(true),
    btn_reloadmsg           = document.getElementById("reloadmsg"),
    btn_reloadAllmsg        = document.getElementById("reloadAllMSG")
    ;

//////////////////////////////////////////////////
//prefil
//////////////////////////////////////////////////
updatedispaly();
updateChat();

async function updatedispaly(){
    window.localStorage.setItem('chatid', JSON.parse(await dbcjss_promSessioninfo('chatid'))['chatid'])
    let res = JSON.parse(await dbcjss_promSessioninfo('chatname'));
    chatnamedisplays.forEach((ele)=>{ele.innerText = res['chatname'];});
    // console.log('updated display');
}

async function updateChat(doclear = false, insertLocation = 'beforeend'){//beforeend
    if(doclear){
        window.localStorage.setItem('msglastupdate', 0);
        msg_display.innerHTML = '';
        console.log('cleared msgs');
    }

    let urlp    = new URLSearchParams();
        urlp.set("ctid", window.localStorage.getItem("chatid"));
        urlp.set('count', 'all');
        urlp.set('aftT', window.localStorage.getItem('msglastupdate'));
    let xhr     = new XMLHttpRequest();

    xhr.open("GET", "/request/chat/getmsg.php?" + urlp.toString(), true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            console.log('update chat: ' + urlp.get('ctid') + '\n' + "/request/chat/getmsg.php?" + urlp.toString() + '\n' + xhr.response);
            let data = JSON.parse(xhr.response);
            for(const val of data.values())
                msg_display.insertAdjacentElement(insertLocation,mkMsgCard(val));
        }
    };
    xhr.send(null);
    window.localStorage.setItem('msglastupdate', (Date.now()/1000).toFixed(1));
}

function mkMsgCard(vals){
    let ele = msg_template.cloneNode(true);
    let ebdy = ele.querySelector('.card-body');
        ebdy.querySelector('.user').innerText  = vals['by'];
        ebdy.querySelector('.time').innerText   = ((Date.now()/1000 - vals['td'])/(36e2)).toFixed(1) + "hr ago";
        ebdy.querySelector('.msg').innerText    = vals['msg'];
    return ele;
}

btn_reloadmsg.addEventListener('click', () => {
    console.log('checking for newer msgs');
    updateChat();
});

btn_reloadAllmsg.addEventListener('click', () => {
    console.log('reloadign all msgs');
    updateChat(true);
});

//////////////////////////////////////////////////
//join chat 
//////////////////////////////////////////////////
form_joinchat.addEventListener('submit', (v)=>{
    v.preventDefault();
    let fd = new FormData(form_joinchat);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "/request/chat/joinchat.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            console.log(xhr.response);

            updatedispaly();
        }
    };
    xhr.send(fd);
});

//////////////////////////////////////////////////
//messageing
//////////////////////////////////////////////////
form_messagebox.addEventListener("submit", (v)=>{
    v.preventDefault();
    let fd = new FormData(form_messagebox);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "/request/chat/insertmsg.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            console.log(xhr.response);

            updateChat(false, 'afterbegin');
        }
    };
    xhr.send(fd);
});