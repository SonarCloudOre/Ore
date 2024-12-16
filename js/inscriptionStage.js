import {Send} from './sms.js';


var telephonesStage = document.getElementById("nums").value;
var msg = document.getElementById("message").value;



await Send(telephonesStage,msg,null);