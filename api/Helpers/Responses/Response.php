<?php

class Response
{
    //Generic information errors
    const E_NOSERVICE 			= 0;
    const E_NOCREDENTIALS 		= 1;
    const E_INVALIDCREDENTIALS  = 2;
    const E_INVALIDTOKEN		= 3;
    const E_USEREXISTS			= 4;
    const E_INVALIDEMAIL		= 5;
    const E_EMPTYCREDENTIALS	= 6;
    const E_NOTLOGGEDIN         = 7;
    const E_FILEDOESNTEXIST     = 8;
    //System errors
    const E_INTERNALERROR       = -100;
    const E_INVALIDMETHOD       = -3;
    const E_INVALIDREQUESTTYPE	= -2;
    const E_NORETURN			= -1;
    //Success responses
    const R_USERACCOUNTCREATED	= 400;
    const R_TOKENCALLBACK		= 401;
    const R_LOGOUTSUCCESS		= 402;
    const R_DATACALLBACK        = 403;
    const R_NODATA              = 404;
    const R_INVALIDDATA         = 405;
}
?>