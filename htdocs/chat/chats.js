document.addEventListener("DOMContentLoaded", function(){
    const   btn_toDtop      = document.getElementById("toDtop!"),
            form_srch       = document.getElementById("form-search"),
            t_body          = document.getElementById("tbody"),
            t_rowTemplate   = t_body.querySelector("template").content.querySelector("tr"),
            srch_cmpAgainst = form_srch.querySelector("#cmpari"),
            srch_ordBy      = form_srch.querySelector("#orderBy")
        ;

    //////////////////////////////////////////////////
    //prefil search -php ahndles some of it already but looks like crap. js better
    //////////////////////////////////////////////////
    {
        let _urlParams  = new URLSearchParams(window.location.search);

        if(_urlParams.has("cmpari"))    _selSelected(srch_cmpAgainst.querySelectorAll("option") , _urlParams.get('cmpari'));
        if(_urlParams.has("orderBy"))   _selSelected(srch_ordBy.querySelectorAll("option")      , _urlParams.get('orderBy'));
        
        function _selSelected(eleArr, srchVal){
            eleArr.forEach((v)=>{
                if(v.getAttribute('value') == srchVal)  v.setAttribute("selected","");
                else    v.removeAttribute('selected');
            });
        }
    }
    
    //////////////////////////////////////////////////
    //search handler
    //////////////////////////////////////////////////
    form_srch.addEventListener('submit', (v)=>{
        //theres most defiently a better way to do this but i cant find anything on it
        let a = document.createElement('input');
            a.setAttribute('name', 'select');
            a.setAttribute('value', 'title,usersonline,description');
        form_srch.appendChild(a);
    });

    let srch_xhr = new XMLHttpRequest();
    srch_xhr.open("GET", '/request/chat/searchChats.php' + window.location.search, true)
    srch_xhr.addEventListener('load', () =>{
        if(srch_xhr.readyState === XMLHttpRequest.DONE && srch_xhr.status == 200){
            // console.log('ret:\n' + srch_xhr.response);

            let curETime    = Date.now()/1000,
                data        = JSON.parse(srch_xhr.response)
                ;

            for(const val of data.values()){
                let row     = t_rowTemplate.cloneNode(true),
                    eles    = row.querySelectorAll("td")
                    ;
                //0 : icon
                
                //1 : title
                let a = eles[1].querySelector("a");
                a.setAttribute("href", "/chat/chats.html");
                a.innerText = val['title'];

                //2 : num online
                eles[2].innerText = val['usersonline']; 

                // //3 : creation date
                // let d = new Date(0); d.setSeconds(val['creationtime']);
                // eles[3].innerText = d.toLocaleDateString();

                // //4 : latest event
                // eles[4].innerText = ((curETime - val['lastactivetime'])/(36e2)).toFixed(1) + "hr ago";

                //3 : descripiton 
                eles[3].innerText = val['descripiton'];

                t_body.insertAdjacentElement("beforeend", row);
            }
        }
    });
    srch_xhr.send(null);

    btn_toDtop.addEventListener('onclick',()=>{document.body.scrollTop = 0; document.documentElement.scrollTop = 0; });
    window.addEventListener('scroll', ()=>{
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) 
            mybutton.style.display = "block";
        else
            mybutton.style.display = "none";
    });
});