/*
example below
------------------------- 
<div class="navbar-header">
    <ul class="navbar-nav nav" id="__navbarlist"></ul> 
    <script type="text/javascript" src="/request/navbar.js" data-insertListID="__navbarlist" data-exclude="/chat/page3.html"></script>
</div>
--------------------------
note
- would work just as well as php or just pre generated code. 
*/

document.addEventListener("DOMContentLoaded", genNavbarPageLi());

/*
- requres doc to be fully loaded before running. ^command above handles it
*/
function genNavbarPageLi(){
    let this_js = document.currentScript;

    //if a target element(val) exists
    if((val = this_js.getAttribute('data-insertListID')) !== "undefined" ){
        const root = document.getElementById(val);

        fetch("/request/navbarpages.json").then((resp) => 
            resp.json().then((data) => {                

                //takes host file out of navbar. compares by file path
                if((filt = this_js.getAttribute("data-exclude")).length != 0) {
                    //regex evil. lose some functionality but works pretty much the same
                    data = data.filter((ele) => {
                        return !!!(ele.href.endsWith(filt)); //wonky -> https://stackoverflow.com/a/7052825
                    })
                }
                
                //creates html <li> elements for remaning pages
                data.forEach((ele) => {
                    li = document.createElement("li");
                        li.setAttribute('class','nav-item')
                    a = document.createElement("a");
                        a.setAttribute('class','nav-link');
                        a.setAttribute('href',ele.href);
                        a.innerHTML = ele.as;
                        
                    li.append(a);
                    root.append( li );
                });
            })
        );
    } 
    //else {console.log('no target element for navbar <li>');}
}