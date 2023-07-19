export function dbcjss_promSessioninfo(key){
    return new Promise((res, rej) => {
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "/request/sessioninfo.php?attribute=" + String(key), true);
        xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) 
                return res(xhr.response);
            else rej('sessioninfo XHR failed');
        };
        xhr.send(null);
    });
}