/**
 * @name getLettreFroGridFromIndice
 * @param {int} p_indice
 * @param {int} p_modulo
 * @returns {String}
 */
function getLettreFroGridFromIndice(p_indice, p_modulo) {
    try {
        var strRetour = "a";
        
        var reste = p_indice % p_modulo;
        
        switch (reste) { 
            case 0: 
                strRetour = "a";
                break;  
            case 1: 
                strRetour = "b";
                break;  
            case 2: 
                strRetour = "c";
                break;  
            case 3: 
                strRetour = "d";
                break;  
            case 4: 
                strRetour = "e";
                break;  
            case 5: 
                strRetour = "f";
                break;  
            default: 
                break; 
        }
        
        return strRetour;
    } catch (er) {
        log(0, "ERROR(getLettreFroGridFromIndice):" + er.message);
        return "";
    }
}