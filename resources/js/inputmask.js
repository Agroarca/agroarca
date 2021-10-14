const InputMask = require('inputmask')
Inputmask({ "alias": "decimal", rightAlign: false, min: 1, max: 100, digits: 2 }).mask('.mask-percentual');