<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../../../bootstrap.php';

use JsonSchema\Constraints\Constraint;
use JsonSchema\Constraints\Factory;
use JsonSchema\SchemaStorage;
use JsonSchema\Validator;

//S-2200 versão inicial e-social simplificado v1.0.0

$evento  = 'evtAdmissao';
$version = 'S_01_00_00';

$jsonSchema = '{
    "title": "evtAdmissao",
    "type": "object",
    "properties": {
        "sequencial": {
            "required": true,
            "type": "integer",
            "minimum": 1,
            "maximum": 99999
        },
        "indretif": {
            "required": true,
            "type": "integer",
            "minimum": 1,
            "maximum": 2
        },
        "nrrecibo": {
            "required": false,
            "type": ["string","null"],
            "maxLength": 40
        },
        "cpftrab": {
            "required": true,
            "type": "string",
            "pattern": "^[0-9]{11}"
        },
        "nmtrab": {
            "required": true,
            "type": "string",
            "maxLength": 70
        },
        "sexo": {
            "required": true,
            "type": "string",
            "pattern": "M|F"
        },
        "racacor": {
            "required": true,
            "type": "integer",
            "minimum": 1,
            "maximum": 6
        },
        "estciv": {
            "required": false,
            "type": ["integer","null"],
            "minimum": 1,
            "maximum": 5
        },
        "grauinstr": {
            "required": true,
            "type": "string",
            "minLength": 2,
            "maxLength": 2,
            "pattern": "^(01|02|03|04|05|06|07|08|09|10|11|12)$"
        },
        "nmsoc": {
            "required": false,
            "type": ["string","null"],
            "maxLength": 70
        },
        "dtnascto": {
            "required": true,
            "type": "string",
            "pattern": "^(19[0-9][0-9]|2[0-9][0-9][0-9])[-/](0?[1-9]|1[0-2])[-/](0?[1-9]|[12][0-9]|3[01])$"
        },
        "paisnascto": {
            "required": true,
            "type": "string",
            "minLength": 3,
            "maxLength": 3,
            "pattern": "^[0-9]{3}$"
        },
        "paisnac": {
            "required": true,
            "type": "string",
            "minLength": 3,
            "maxLength": 3,
            "pattern": "^[0-9]{3}$"
        },
        "endereco": {
            "required": true,
            "type": "object",
            "properties": {
                "brasil": {
                    "required": false,
                    "type": ["object","null"],
                    "properties": {
                        "tplograd": {
                            "required": false,
                            "type": ["string", "null"],
                            "maxLength": 4
                        },
                        "dsclograd": {
                            "required": true,
                            "type": "string",
                            "maxLength": 80
                        },
                        "nrlograd": {
                            "required": true,
                            "type": "string",
                            "maxLength": 10
                        },
                        "complemento": {
                            "required": false,
                            "type": ["string","null"],
                            "maxLength": 30
                        },
                        "bairro": {
                            "required": false,
                            "type": ["string","null"],
                            "maxLength": 60
                        },
                        "cep": {
                            "required": true,
                            "type": "string",
                            "maxLength": 8
                        },
                        "codmunic": {
                            "required": true,
                            "type": "integer",
                            "maxLength": 7
                        },
                        "uf": {
                            "required": true,
                            "type": "string",
                            "maxLength": 2
                        }
                    }
                },
                "exterior": {
                    "required": false,
                    "type": ["object","null"],
                    "properties": {
                        "paisresid": {
                            "required": true,
                            "type": "string",
                            "maxLength": 3
                        },
                        "dsclograd": {
                            "required": true,
                            "type": "string",
                            "maxLength": 80
                        },
                        "nrlograd": {
                            "required": true,
                            "type": "string",
                            "maxLength": 10
                        },
                        "complemento": {
                            "required": false,
                            "type": ["string","null"],
                            "maxLength": 30
                        },
                        "bairro": {
                            "required": false,
                            "type": ["string","null"],
                            "maxLength": 60
                        },
                        "nmcid": {
                            "required": true,
                            "type": "string",
                            "maxLength": 50
                        },
                        "codpostal": {
                            "required": true,
                            "type": "string",
                            "maxLength": 12
                        }
                    }
                }
            }
        },
        "trabimig": {
            "required": false,
            "type": "object",
            "properties": {
                "tmpresid": {
                    "required": true,
                    "type": "integer",
                    "minimum": 1,
                    "maximum": 2
                },
                "conding": {
                    "required": true,
                    "type": "integer",
                    "minimum": 1,
                    "maximum": 7
                }
            }
        },
        "deficiencia": {
            "required": false,
            "type": ["object","null"],
            "properties": {
                "deffisica": {
                    "required": true,
                    "type": "string",
                    "pattern": "S|N"
                },
                "defvisual": {
                    "required": true,
                    "type": "string",
                    "pattern": "S|N"
                },
                "defauditiva": {
                    "required": true,
                    "type": "string",
                    "pattern": "S|N"
                },
                "defmental": {
                    "required": true,
                    "type": "string",
                    "pattern": "S|N"
                },
                "defintelectual": {
                    "required": true,
                    "type": "string",
                    "pattern": "S|N"
                },
                "reabreadap": {
                    "required": true,
                    "type": "string",
                    "pattern": "S|N"
                },
                "infocota": {
                    "required": true,
                    "type": "string",
                    "pattern": "S|N"
                },
                "observacao": {
                    "required": false,
                    "type": "string",
                    "maxLength": 255
                }
            }
        },
        "dependente": {
            "required": false,
            "type": ["array","null"],
            "minItems": 0,
            "maxItems": 99,
            "items": {
                "type": "object",
                "properties": {
                    "tpdep": {
                        "required": true,
                        "type": "string",
                        "maxLength": 2
                    },
                    "nmdep": {
                        "required": true,
                        "type": "string",
                        "maxLength": 70
                    },
                    "dtnascto": {
                        "required": true,
                        "type": "string",
                        "pattern": "^(19[0-9][0-9]|2[0-9][0-9][0-9])[-/](0?[1-9]|1[0-2])[-/](0?[1-9]|[12][0-9]|3[01])$"
                    },
                    "cpfdep": {
                        "required": false,
                        "type": ["string","null"],
                        "maxLength": 11,
                        "minLength": 1
                    },
                    "sexodep": {
                        "required": false,
                        "type": ["string","null"],
                        "pattern": "M|F"
                    },
                    "depirrf": {
                        "required": false,
                        "type": ["string","null"],
                        "pattern": "S|N"
                    },
                    "depsf": {
                        "required": true,
                        "type": "string",
                        "pattern": "S|N"
                    },
                    "inctrab": {
                        "required": true,
                        "type": "string",
                        "pattern": "S|N"
                    }
                }
            }
        },
        "contato": {
            "required": false,
            "type": ["object","null"],
            "properties": {
                "foneprinc": {
                    "required": false,
                    "type": ["string","null"],
                    "maxLength": 13
                },
                "emailprinc": {
                    "required": false,
                    "type": ["string","null"],
                    "maxLength": 60
                }
            }
        },
        "vinculo": {
            "required": true,
            "type": "object",
            "properties": {
                "matricula": {
                    "required": true,
                    "type": "string",
                    "maxLength": 30
                },
                "tpregtrab": {
                    "required": true,
                    "type": "integer",
                    "minimum": 1,
                    "maximum": 2
                },
                "tpregprev": {
                    "required": true,
                    "type": "integer",
                    "minimum": 1,
                    "maximum": 3
                },
                "cadini": {
                    "required": true,
                    "type": "string",
                    "pattern": "S|N"
                },
                "infoceletista": {
                    "required": false,
                    "type": ["object","null"],
                    "properties": {
                        "dtadm": {
                            "required": true,
                            "type": "string",
                            "pattern": "^(19[0-9][0-9]|2[0-9][0-9][0-9])[-/](0?[1-9]|1[0-2])[-/](0?[1-9]|[12][0-9]|3[01])$"
                        },
                        "tpadmissao": {
                            "required": true,
                            "type": "integer",
                            "minimum": 1,
                            "maximum": 6
                        },
                        "indadmissao": {
                            "required": true,
                            "type": "integer",
                            "minimum": 1,
                            "maximum": 3
                        },
                        "nrproctrab": {
                            "required": false,
                            "type": ["string", "null"],
                            "maxLength": 20
                        },
                        "tpregjor": {
                            "required": true,
                            "type": "integer",
                            "minimum": 1,
                            "maximum": 4
                        },
                        "natatividade": {
                            "required": true,
                            "type": "integer",
                            "minimum": 1,
                            "maximum": 2
                        },
                        "dtbase": {
                            "required": false,
                            "type": "integer",
                            "minimum": 1,
                            "maximum": 12
                        },
                        "cnpjsindcategprof": {
                            "required": true,
                            "type": "string",
                            "pattern": "^[0-9]{14}$"
                        },
                        "dtopcfgts": {
                            "required": false,
                            "type": ["string","null"],
                            "pattern": "^(19[0-9][0-9]|2[0-9][0-9][0-9])[-/](0?[1-9]|1[0-2])[-/](0?[1-9]|[12][0-9]|3[01])$"
                        },
                        "trabtemporario": {
                            "required": false,
                            "type": ["object","null"],
                            "properties": {
                                "hipleg": {
                                    "required": true,
                                    "type": "integer",
                                    "minimum": 1,
                                    "maximum": 2
                                },
                                "justcontr": {
                                    "required": true,
                                    "type": "string",
                                    "maxLength": 999
                                },
                                "ideestabvinc": {
                                    "required": true,
                                    "type": "object",
                                    "properties": {
                                        "tpinsc": {
                                            "required": true,
                                            "type": "integer",
                                            "minimum": 1,
                                            "maximum": 2
                                        },
                                        "nrinsc": {
                                            "required": true,
                                            "type": "string",
                                            "pattern": "^[0-9]{11,14}$"
                                        }
                                    }
                                },
                                "idetrabsubstituido": {
                                    "required": false,
                                    "type": ["array","null"],
                                    "minItems": 0,
                                    "maxItems": 9,
                                    "items": {
                                        "type": "object",
                                        "properties": {
                                            "cpftrabsubst": {
                                                "required": true,
                                                "type": "string",
                                                "pattern": "^[0-9]{11}$"
                                            }
                                        }
                                    }
                                }
                            }
                        },
                        "aprend": {
                            "required": false,
                            "type": ["object","null"],
                            "properties": {
                                "tpinsc": {
                                    "required": true,
                                    "type": "integer",
                                    "minimum": 1,
                                    "maximum": 2
                                },
                                "nrinsc": {
                                    "required": true,
                                    "type": "string",
                                    "pattern": "^[0-9]{11,14}$"
                                }
                            }
                        }
                    }    
                },
                "infoestatutario": {
                    "required": false,
                    "type": "object",
                    "properties": {
                        "tpprov": {
                            "required": true,
                            "type": "integer",
                            "minimum": 1,
                            "maximum": 99
                        },                        
                        "dtexercicio": {
                            "required": true,
                            "type": "string",
                            "pattern": "^(19[0-9][0-9]|2[0-9][0-9][0-9])[-/](0?[1-9]|1[0-2])[-/](0?[1-9]|[12][0-9]|3[01])$"
                        },
                        "tpplanrp": {
                            "required": false,
                            "type": "integer",
                            "minimum": 1,
                            "maximum": 2
                        },
                        "indtetorgps": {
                            "required": false,
                            "type": ["string", "null"],
                            "pattern": "S|N"
                        },
                        "indabonoperm": {
                            "required": false,
                            "type": ["string", "null"],
                            "pattern": "S|N"
                        },
                        "dtiniabono": {
                            "required": false,
                            "type": ["string", "null"],
                            "pattern": "^(19[0-9][0-9]|2[0-9][0-9][0-9])[-/](0?[1-9]|1[0-2])[-/](0?[1-9]|[12][0-9]|3[01])$"
                        }
                    }    
                },
                "infocontrato": {
                    "required": false,
                    "type": "object",
                    "properties": {
                        "nmcargo": {
                              "required": false,
                              "type": ["string","null"],
                              "maxLength": 100
                        },
                        "cbocargo": {
                              "required": false,
                              "type": ["string","null"],
                              "maxLength": 6
                        },
                        "dtingrcargo": {
                            "required": false,
                            "type": "string",
                            "pattern": "^(19[0-9][0-9]|2[0-9][0-9][0-9])[-/](0?[1-9]|1[0-2])[-/](0?[1-9]|[12][0-9]|3[01])$"
                        },
                        "nmfuncao": {
                              "required": false,
                              "type": ["string","null"],
                              "maxLength": 100
                        },
                        "cbofuncao": {
                              "required": false,
                              "type": ["string","null"],
                              "maxLength": 6
                        },
                        "acumcargo": {
                              "required": false,
                              "type": ["string","null"],
                              "pattern": "S|N"
                        },
                        "codcateg": {
                              "required": false,
                              "type": "integer",
                              "minimum": 101,
                              "maximum": 905
                        },
                        "remuneracao": {
                            "required": false,
                            "type": ["object","null"],
                            "properties": {
                                "vrsalfx": {
                                    "required": false,
                                    "type": "number"
                                },
                                "undsalfixo": {
                                    "required": false,
                                    "type": "integer",
                                    "minimum": 1,
                                    "maximum": 7
                                },
                                "dscsalvar": {
                                    "required": false,
                                    "type": ["string","null"],
                                    "maxLength": 255
                                }
                            }
                        },
                        "duracao": {
                            "required": false,
                            "type": ["object","null"],
                            "properties": {
                                "tpcontr": {
                                    "required": false,
                                    "type": "integer",
                                    "minimum": 1,
                                    "maximum": 2
                                },
                                "dtterm": {
                                    "required": false,
                                    "type": ["string","null"],
                                    "pattern": "^(19[0-9][0-9]|2[0-9][0-9][0-9])[-/](0?[1-9]|1[0-2])[-/](0?[1-9]|[12][0-9]|3[01])$"
                                },
                                "clauassec": {
                                    "required": false,
                                    "type": ["string","null"],
                                    "pattern": "^(S|N)$"
                                },
                                "objdet": {
                                    "required": false,
                                    "type": ["string","null"],
                                    "pattern": "^.{1,255}$"
                                }
                            }
                         },
                        "localtrabgeral": {
                            "required": false,
                            "type": ["object","null"],
                            "properties": {
                                "tpinsc": {
                                    "required": true,
                                    "type": "integer",
                                    "minimum": 1,
                                    "maximum": 2
                                },
                                "nrinsc": {
                                    "required": true,
                                    "type": "string",
                                    "pattern": "^[0-9]{11,14}$"
                                },
                                "desccomp": {
                                      "required": false,
                                      "type": ["string","null"],
                                      "maxLength": 80
                                }
                            }
                        },
                        "localtempdom": {
                            "required": false,
                            "type": ["object","null"],
                            "properties": {
                                "tplograd": {
                                    "required": true,
                                    "type": "string",
                                    "maxLength": 4
                                },
                                "dsclograd": {
                                    "required": true,
                                    "type": "string",
                                    "maxLength": 80
                                },
                                "nrlograd": {
                                    "required": true,
                                    "type": "string",
                                    "maxLength": 10
                                },
                                "complemento": {
                                    "required": false,
                                    "type": ["string","null"],
                                    "maxLength": 30
                                },
                                "bairro": {
                                    "required": false,
                                    "type": ["string","null"],
                                    "maxLength": 60
                                },
                                "cep": {
                                    "required": true,
                                    "type": "string",
                                    "pattern": "^[0-9]{8}$"
                                },
                                "codmunic": {
                                    "required": true,
                                    "type": "string",
                                    "pattern": "^[0-9]{7}$"
                                },
                                "uf": {
                                    "required": true,
                                    "type": "string",
                                    "maxLength": 2
                                }
                            }
                        },
                        "horcontratual": {
                            "required": false,
                            "type": ["object","null"],
                            "properties": {
                                "qtdhrssem": {
                                    "required": true,
                                    "type": "number",
                                    "minimum": 0.1,
                                    "maximum": 99.99
                                },
                                "tpjornada": {
                                    "required": true,
                                    "type": "integer",
                                    "minimum": 1,
                                    "maximum": 9
                                },
                                "tmpparc": {
                                    "required": true,
                                    "type": "integer",
                                    "minimum": 0,
                                    "maximum": 3
                                },
                                "hornoturno": {
                                    "required": false,
                                    "type": ["string", "null"],
                                    "pattern": "S|N"
                                },
                                "dscjorn": {
                                    "required": true,
                                    "type": ["string", "null"],
                                    "maxLength": 999
                                }
                            }
                        },
                        "alvarajudicial": {
                            "required": false,
                            "type": ["object","null"],
                            "properties": {
                                "nrprocjud": {
                                    "required": false,
                                    "type": ["string","null"],
                                    "pattern": "^.{20}$"
                                }
                            }
                        },
                        "observacoes": {
                            "required": false,
                            "type": ["array","null"],
                            "minItems": 0,
                            "maxItems": 99,
                            "items": {
                                "type": "object",
                                "properties": {
                                    "observacao": {
                                        "required": true,
                                        "type": "string",
                                        "maxLength": 255
                                    }
                                }    
                            }
                        },
                        "treicap": {
                            "required": false,
                            "type": ["array","null"],
                            "minItems": 0,
                            "maxItems": 99,
                            "items": {
                                "type": "object",
                                "properties": {
                                    "codtreicap": {
                                        "required": true,
                                        "type": "integer",
                                        "minimum": 1,
                                        "maximum": 9999
                                    }
                                }    
                            }
                        }
                    }    
                },
                "sucessaovinc": {
                    "required": false,
                    "type": ["object","null"],
                    "properties": {
                        "tpinsc": {
                            "required": true,
                            "type": "integer",
                            "minimum": 1,
                            "maximum": 5
                        },
                        "nrinsc": {
                            "required": true,
                            "type": "string",
                            "pattern": "^[0-9]{14}$"
                        },
                        "matricant": {
                              "required": false,
                              "type": ["string","null"],
                              "maxLength": 30
                        },
                        "dttransf": {
                            "required": true,
                            "type": "string",
                            "pattern": "^(19[0-9][0-9]|2[0-9][0-9][0-9])[-/](0?[1-9]|1[0-2])[-/](0?[1-9]|[12][0-9]|3[01])$"
                        },
                        "observacao": {
                            "required": false,
                            "type": ["string","null"],
                            "maxLength": 255
                        }
                    }
                },
                "transfdom": {
                    "required": false,
                    "type": ["object","null"],
                    "properties": {
                        "cpfsubstituido": {
                            "required": true,
                            "type": "string",
                            "pattern": "^[0-9]{11}$"
                        },
                        "matricant": {
                              "required": false,
                              "type": ["string","null"],
                              "maxLength": 30
                        },
                        "dttransf": {
                            "required": true,
                            "type": "string",
                            "pattern": "^(19[0-9][0-9]|2[0-9][0-9][0-9])[-/](0?[1-9]|1[0-2])[-/](0?[1-9]|[12][0-9]|3[01])$"
                        }
                    }
                },
                "mudancacpf": {
                    "required": false,
                    "type": ["object","null"],
                    "properties": {
                        "cpfant": {
                            "required": true,
                            "type": "string",
                            "pattern": "^[0-9]{11}$"
                        },
                        "matricant": {
                            "required": false,
                            "type": ["string","null"],
                            "maxLength": 30
                        },
                        "dtaltcpf": {
                            "required": true,
                            "type": "string",
                            "pattern": "^(19[0-9][0-9]|2[0-9][0-9][0-9])[-/](0?[1-9]|1[0-2])[-/](0?[1-9]|[12][0-9]|3[01])$"
                        },
                        "observacao": {
                            "required": false,
                            "type": ["string","null"],
                            "maxLength": 255
                        }
                    }
                },
                "afastamento": {
                    "required": false,
                    "type": ["object","null"],
                    "properties": {
                        "dtiniafast": {
                            "required": true,
                            "type": "string",
                            "pattern": "^(19[0-9][0-9]|2[0-9][0-9][0-9])[-/](0?[1-9]|1[0-2])[-/](0?[1-9]|[12][0-9]|3[01])$"
                        },
                        "codmotafast": {
                             "required": true,
                             "type": "string",
                             "pattern": "^[0-9]{2}$"
                        }
                    }
                },
                "desligamento": {
                    "required": false,
                    "type": ["object","null"],
                    "properties": {
                        "dtdeslig": {
                            "required": true,
                            "type": "string",
                            "pattern": "^(19[0-9][0-9]|2[0-9][0-9][0-9])[-/](0?[1-9]|1[0-2])[-/](0?[1-9]|[12][0-9]|3[01])$"
                        }
                    }
                },
                "cessao": {
                    "required": false,
                    "type": ["object","null"],
                    "properties": {
                        "dtinicessao": {
                            "required": true,
                            "type": "string",
                            "pattern": "^(19[0-9][0-9]|2[0-9][0-9][0-9])[-/](0?[1-9]|1[0-2])[-/](0?[1-9]|[12][0-9]|3[01])$"
                        }
                    }
                }
            }    
        }        
    }
}';

$std = new \stdClass();
$std->sequencial = 1;
$std->indretif = 1;
$std->nrrecibo = 'ABJBAJBJAJBAÇÇAAKJ';
$std->cpftrab = '11111111111';
$std->nmtrab = 'JOSE DA SILVA';
$std->sexo = 'M';
$std->racacor = 5;
$std->estciv = 1;
$std->grauinstr = '07';
$std->nmsoc = 'Chiquinho';
$std->dtnascto = '1980-01-01';
$std->paisnascto = '105'; // 105 = Brasil
$std->paisnac = '105';

$std->endereco = new \stdClass();
$std->endereco->brasil = new \stdClass();
$std->endereco->brasil->tplograd = 'R';
$std->endereco->brasil->dsclograd = 'Av. Paulista';
$std->endereco->brasil->nrlograd = '1850';
$std->endereco->brasil->bairro = 'Bela Vista';
$std->endereco->brasil->cep = '01311200';
$std->endereco->brasil->codmunic  = 3550308;
$std->endereco->brasil->uf = 'SP';

$std->endereco->exterior = new \stdClass();
$std->endereco->exterior->paisresid = '108';
$std->endereco->exterior->dsclograd = '5 Av';
$std->endereco->exterior->nrlograd = '2222';
$std->endereco->exterior->complemento = 'Apto 200';
$std->endereco->exterior->bairro = 'Manhattan';
$std->endereco->exterior->nmcid = 'New York';
$std->endereco->exterior->codpostal  = '111111';

$std->trabimig = new \stdClass();
$std->trabimig->tmpresid = 1;
$std->trabimig->conding = 2;

$std->infodeficiencia = new \stdClass();
$std->infodeficiencia->deffisica = 'N';
$std->infodeficiencia->defvisual = 'N';
$std->infodeficiencia->defauditiva = 'N';
$std->infodeficiencia->defmental = 'N';
$std->infodeficiencia->defintelectual = 'N';
$std->infodeficiencia->reabreadap = 'N';
$std->infodeficiencia->infocota = 'N';
$std->infodeficiencia->observacao = 'slsklskslkslkslkssklsklsjksjskjs';

$std->dependente[0] = new \stdClass();
$std->dependente[0]->tpdep = '01';
$std->dependente[0]->nmdep = 'WATSON';
$std->dependente[0]->dtnascto = '2015-01-01';
$std->dependente[0]->cpfdep = '12345678985';
$std->dependente[0]->sexodep = 'F';
$std->dependente[0]->depirrf = 'N';
$std->dependente[0]->depsf = 'N';
$std->dependente[0]->inctrab = 'N';

$std->contato = new \stdClass();
$std->contato->foneprinc = '1155555555';
$std->contato->emailprinc = 'beltrano@mail.com.br';

$std->vinculo = new \stdClass();
$std->vinculo->matricula = '1020304050';
$std->vinculo->tpregtrab = 1;
$std->vinculo->tpregprev = 1;
$std->vinculo->cadini = 'S';

$std->vinculo->infoceletista = new \stdClass();
$std->vinculo->infoceletista->dtadm = '2017-08-08';
$std->vinculo->infoceletista->tpadmissao = 1;
$std->vinculo->infoceletista->indadmissao = 1;
$std->vinculo->infoceletista->nrproctrab = '12345678901234567890';
$std->vinculo->infoceletista->tpregjor = 1;
$std->vinculo->infoceletista->natatividade = 1;
$std->vinculo->infoceletista->dtbase = 1;
$std->vinculo->infoceletista->cnpjsindcategprof = '77721644000101';
$std->vinculo->infoceletista->dtopcfgts = '2017-01-01';

$std->vinculo->infoceletista->trabtemporario = new \stdClass();
$std->vinculo->infoceletista->trabtemporario->hipleg = 1;
$std->vinculo->infoceletista->trabtemporario->justcontr = 'jwkjwkjwkjwk';

$std->vinculo->infoceletista->trabtemporario->ideestabvinc = new \stdClass();
$std->vinculo->infoceletista->trabtemporario->ideestabvinc->tpinsc = 2;
$std->vinculo->infoceletista->trabtemporario->ideestabvinc->nrinsc = '12345678901234';

$std->vinculo->infoceletista->trabtemporario->idetrabsubstituido[0] = new \stdClass();
$std->vinculo->infoceletista->trabtemporario->idetrabsubstituido[0]->cpftrabsubst = '12345678901';

$std->vinculo->infoceletista->aprend = new \stdClass();
$std->vinculo->infoceletista->aprend->tpinsc = 1;
$std->vinculo->infoceletista->aprend->nrinsc = '12345678901';

$std->vinculo->infoestatutario = new \stdClass();
$std->vinculo->infoestatutario->tpprov = 99;
$std->vinculo->infoestatutario->dtexercicio = '2017-02-01';
$std->vinculo->infoestatutario->tpplanrp = 2;
$std->vinculo->infoestatutario->indtetorgps = 'S';
$std->vinculo->infoestatutario->indabonoperm = 'S';
$std->vinculo->infoestatutario->dtiniabono = '2017-02-01';

$std->vinculo->infocontrato = new \stdClass();
$std->vinculo->infocontrato->nmcargo = 'Melhor cargo do país';
$std->vinculo->infocontrato->cbocargo = '123456';
$std->vinculo->infocontrato->dtingrcargo = '2017-02-01';
$std->vinculo->infocontrato->nmfuncao = 'Melhor função de todas';
$std->vinculo->infocontrato->cbofuncao = '654321';
$std->vinculo->infocontrato->acumcargo = 'S';
$std->vinculo->infocontrato->codcateg = 101;
$std->vinculo->infocontrato->remuneracao = new \stdClass();
$std->vinculo->infocontrato->remuneracao->vrsalfx = 2547.56;
$std->vinculo->infocontrato->remuneracao->undsalfixo = 7;
$std->vinculo->infocontrato->remuneracao->dscsalvar = 'ksksksksk';
$std->vinculo->infocontrato->duracao = new \stdClass();
$std->vinculo->infocontrato->duracao->tpcontr = 1;
$std->vinculo->infocontrato->duracao->dtterm = '2018-01-01';
$std->vinculo->infocontrato->duracao->clauassec = 'N';
$std->vinculo->infocontrato->duracao->objdet = 'ksksks';

$std->vinculo->infocontrato->localtrabgeral = new \stdClass();
$std->vinculo->infocontrato->localtrabgeral->tpinsc = 2;
$std->vinculo->infocontrato->localtrabgeral->nrinsc = '12345678901234';
$std->vinculo->infocontrato->localtrabgeral->desccomp = 'lkdldkldkldk';

$std->vinculo->infocontrato->localtempdom = new \stdClass();
$std->vinculo->infocontrato->localtempdom->tplograd = 'AV';
$std->vinculo->infocontrato->localtempdom->dsclograd = 'sm,sm,sms,ms,ms';
$std->vinculo->infocontrato->localtempdom->nrlograd = '27272';
$std->vinculo->infocontrato->localtempdom->complemento = 'sjsksjhsh';
$std->vinculo->infocontrato->localtempdom->bairro = 'sjhsj';
$std->vinculo->infocontrato->localtempdom->cep = '99999999';
$std->vinculo->infocontrato->localtempdom->codmunic = '1234567';
$std->vinculo->infocontrato->localtempdom->uf = 'AC';

$std->vinculo->infocontrato->horcontratual = new \stdClass();
$std->vinculo->infocontrato->horcontratual->qtdhrssem = 99.50;
$std->vinculo->infocontrato->horcontratual->tpjornada = 9;
$std->vinculo->infocontrato->horcontratual->dsctpjorn = 'kjsksjsjs';
$std->vinculo->infocontrato->horcontratual->tmpparc = 0;
$std->vinculo->infocontrato->horcontratual->hornoturno = 'N';
$std->vinculo->infocontrato->horcontratual->dscjorn = 'De 2a a 6a feira, das 8:00 às 12:00 e das 13:00 às 17:00 e no sábado das 8:00 às 12:00';

$std->vinculo->infocontrato->alvarajudicial = new \stdClass();
$std->vinculo->infocontrato->alvarajudicial->nrprocjud = '12345678901234567890';

$std->vinculo->infocontrato->observacoes[0] = new \stdClass();
$std->vinculo->infocontrato->observacoes[0]->observacao = 'kjskjsksksj';

$std->vinculo->infocontrato->treicap[0] = new \stdClass();
$std->vinculo->infocontrato->treicap[0]->codtreicap = 1001;

$std->vinculo->sucessaovinc = new \stdClass();
$std->vinculo->sucessaovinc->tpinsc = 1;
$std->vinculo->sucessaovinc->nrinsc = '12345678901234';
$std->vinculo->sucessaovinc->matricant = 'sksksksk';
$std->vinculo->sucessaovinc->dttransf = '2017-01-01';
$std->vinculo->sucessaovinc->observacao = 'kjsksjksjksj';

$std->vinculo->transfdom = new \stdClass();
$std->vinculo->transfdom->cpfsubstituido = '12345678901';
$std->vinculo->transfdom->matricant = 'slslslsls';
$std->vinculo->transfdom->dttransf = '2017-01-01';

$std->vinculo->mudancacpf = new \stdClass();
$std->vinculo->mudancacpf->cpfant = '12345678901';
$std->vinculo->mudancacpf->matricant = 'slslslsls';
$std->vinculo->mudancacpf->dtaltcpf = '2017-01-01';
$std->vinculo->mudancacpf->observacao = 'kjsksjksjksj';

$std->vinculo->afastamento = new \stdClass();
$std->vinculo->afastamento->dtiniafast = '2017-05-01';
$std->vinculo->afastamento->codmotafast = '01';

$std->vinculo->desligamento = new \stdClass();
$std->vinculo->desligamento->dtdeslig = '2017-08-08';

$std->vinculo->cessao = new \stdClass();
$std->vinculo->cessao->dtinicessao = '2017-08-08';

// Schema must be decoded before it can be used for validation
$jsonSchemaObject = json_decode($jsonSchema);
if (empty($jsonSchemaObject)) {
    echo "<h2>Erro de digitação no schema ! Revise</h2>";
    echo "<pre>";
    print_r($jsonSchema);
    echo "</pre>";
    die();
}

// The SchemaStorage can resolve references, loading additional schemas from file as needed, etc.
$schemaStorage = new SchemaStorage();

// This does two things:
// 1) Mutates $jsonSchemaObject to normalize the references (to file://mySchema#/definitions/integerData, etc)
// 2) Tells $schemaStorage that references to file://mySchema... should be resolved by looking in $jsonSchemaObject
$definitions = realpath(__DIR__."/../../../jsonSchemes/definitions.schema");
$schemaStorage->addSchema("file:{$definitions}", $jsonSchemaObject);

// Provide $schemaStorage to the Validator so that references can be resolved during validation
$jsonValidator = new Validator(new Factory($schemaStorage));

// Do validation (use isValid() and getErrors() to check the result)
$jsonValidator->validate(
    $std,
    $jsonSchemaObject
);

if ($jsonValidator->isValid()) {
    echo "The supplied JSON validates against the schema.<br/>";
} else {
    echo "JSON does not validate. Violations:<br/>";
    foreach ($jsonValidator->getErrors() as $error) {
        echo sprintf("[%s] %s<br/>", $error['property'], $error['message']);
    }
    die;
}
//salva se sucesso
file_put_contents("../../../jsonSchemes/v_$version/$evento.schema", $jsonSchema);
