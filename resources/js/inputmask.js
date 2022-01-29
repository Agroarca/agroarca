const InputMask = require('inputmask')
Inputmask({ "alias": "decimal", rightAlign: false, min: 1, max: 100, digits: 2 }).mask('.mask-percentual');
Inputmask({ "alias": "currency", rightAlign: false, groupSeparator: '' }).mask('.mask-preco');
Inputmask({ "alias": "integer", rightAlign: false, groupSeparator: '' }).mask('.mask-quilo');
Inputmask({ "alias": "integer", rightAlign: false, groupSeparator: '' }).mask('.mask-integer');
Inputmask({ "regex": "\\(\\d{2}\\) \\d{8}\\d?", inputmode: 'tel'}).mask('.mask-telefone');
Inputmask({ "regex": "\\d{3}\\.\\d{3}\\.\\d{3}\\-\\d{2}", inputmode: 'numeric'}).mask('.mask-cpf');
Inputmask({ "regex": "\\d{2}\\.\\d{3}\\.\\d{3}/\\d{4}\\-\\d{2}", inputmode: 'numeric'}).mask('.mask-cnpj');
