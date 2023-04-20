//import { execSync } from 'child_process';
//const execSync = require('child_process').execSync;

function appendTxt(elementId,thingtoAppend){
    try{
        document.getElementById(elementId).innerHTML += thingtoAppend;
    }catch(err){
        console.log('script>appendTxt: failed to append to document element');
    }
}

function clearTxt(elementId){
    try{
        document.getElementById(elementId).innerText = '';
    }catch(err){
        console.log('script>clearTxt: failed to clear text');
    }
}

function sendClii(clii){
    try{
        return execSync(clii, {encoding: 'utf-8'});
    }catch(err){
        console.log('script1>sendClii: failed something');
    }
}

function loadHTML(srcPath){
    try{
        //document.replace(srcPath)
        location.replace(srcPath);
    }catch(err){
        console.log('script1>loadHTML: invalid path? (idk for sure)')
    }
}