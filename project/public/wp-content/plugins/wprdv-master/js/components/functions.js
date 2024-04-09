function verifMail(chaine) {
    var exp=new RegExp("^[a-zA-Z0-9\-\_\+.]{0,256}[@]{1}[a-zA-Z0-9\-\_\+.]{0,256}[.]{1}[a-zA-Z]{0,3}$","g");
    if ( exp.test(chaine) ){ return true; }
    else { return false; }
}