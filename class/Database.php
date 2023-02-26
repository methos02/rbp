<?php
class Database {
    /* ----------- */
    /*  FONCTIONS  */
    /* ----------- */
    CONST F_SPORTIF = ['id' => 1, 'name' => 'Sportif'];
    CONST F_ENTRAINEUR  = ['id' => 2, 'name' => 'Entraineur'];
    CONST F_RESPONSABLE = ['id' => 3, 'name' => 'Responsable'];
    CONST F_MEMBRE_CA = ['id' => 4, 'name' => 'Membre du CA'];

    CONST FON_ID_TO_NAME = [
        self::F_SPORTIF['id'] => self::F_SPORTIF['name'],
        self::F_ENTRAINEUR['id'] => self::F_ENTRAINEUR['name'],
        self::F_RESPONSABLE['id'] => self::F_RESPONSABLE['name'],
        self::F_MEMBRE_CA['id'] => self::F_MEMBRE_CA['name']
    ];

    CONST FONCTIONS = [self::F_SPORTIF, self::F_ENTRAINEUR, self::F_RESPONSABLE];
    CONST CA = [self::F_MEMBRE_CA];

    /* ------------ */
    /*  COTISATION  */
    /* ------------ */
    CONST M_INCONNU = ['id' => 1, 'label' => 'Inconnu'];
    CONST MONTANT_1 = ['id' => 2, 'numb' => 300, 'label' => '300 €'];
    CONST MONTANT_2 = ['id' => 3, 'numb' => 280, 'label' => '280 €'];
    CONST MONTANT_3 = ['id' => 4, 'numb' => 260, 'label' => '260 €'];
    CONST M_DISPENCE = ['id' => 5, 'label' => 'Dispencé'];

    CONST COT_ID_TO_LABEL = [
        self::M_INCONNU['id'] => self::M_INCONNU['label'],
        self::MONTANT_1['id'] => self::MONTANT_1['label'],
        self::MONTANT_2['id'] => self::MONTANT_2['label'],
        self::MONTANT_3['id'] => self::MONTANT_2['label'],
        self::M_DISPENCE['id'] => self::M_DISPENCE['label']
    ];

    CONST COT_ID_TO_NUMB = [
        self::MONTANT_1['id'] => self::MONTANT_1['numb'],
        self::MONTANT_2['id'] => self::MONTANT_2['numb'],
        self::MONTANT_3['id'] => self::MONTANT_2['numb'],
    ];

    CONST ARRAY_NO_COT = [self::M_INCONNU['id'], self::M_DISPENCE['id']];

    /* --------- */
    /*  LICENCE  */
    /* --------- */
    CONST L_NON_INFO = ['id' => 1, 'label' => 'Non Précisé'];
    CONST L_ADHERENT = ['id' => 2, 'label' => 'Adhérent'];
    CONST L_OFFICIEL = ['id' => 3, 'label' => 'Officiel'];
    CONST L_SPORTIF = ['id' => 4, 'label' => 'Sportif'];
    CONST L_NON_LICENCIER = ['id' => 5, 'label' => 'Non licencier'];

    CONST L_ID_TO_LABEL = [
        self::L_NON_INFO['id'] => self::L_NON_INFO['label'],
        self::L_ADHERENT['id'] => self::L_ADHERENT['label'],
        self::L_OFFICIEL['id'] => self::L_OFFICIEL['label'],
        self::L_SPORTIF['id'] => self::L_SPORTIF['label'],
        self::L_NON_LICENCIER['id'] => self::L_NON_LICENCIER['label'],
    ];

    /* ---------- */
    /*  CIVILITE  */
    /* ---------- */
    CONST CIV_MONSIEUR = ['id' => 1, 'name' => 'Monsieur'];
    CONST CIV_MADEMOISELLE = ['id' => 2, 'name' => 'Mademoiselle'];
    CONST CIV_MADAME = ['id' => 3, 'name' => 'Madame'];

    CONST CIV_ID_TO_NAME = [
        self::CIV_MONSIEUR['id'] => self::CIV_MONSIEUR['name'],
        self::CIV_MADEMOISELLE['id'] => self::CIV_MADEMOISELLE['name'],
        self::CIV_MADAME['id'] => self::CIV_MADAME['name'],
    ];
}