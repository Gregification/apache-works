import { dbcjss_promSessioninfo } from "/request/dbcjss.js";

const form_joinchat         = document.getElementById("form-modal-joinchat"),
    form_messagebox         = document.getElementById("form-messagebox"),
    chatnamedisplays        = Array(
            document.getElementById("chatnamedisplay"),
            document.getElementById("modal-chatinfo-chatnamedisplay")
        )
    ;

//////////////////////////////////////////////////
//prefil
//////////////////////////////////////////////////
updatedispaly();
async function updatedispaly(){
    let res = JSON.parse(await dbcjss_promSessioninfo('chatname'));
    chatnamedisplays.forEach((ele)=>{ele.innerText = res['chatname'];});
    // console.log('updated display');
}

async function updateChat(){

}

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

            updatedispaly();
        }
    };
    xhr.send(fd);
});

async function getformattedmessage(){
    
}