<?php
// Configuration de la connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mon_projet_licence";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Fonction pour sécuriser les données entrantes
function secure_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Fonction pour vérifier la validité des fichiers uploadés
function validate_file($file, $allowed_exts, $max_size) {
    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $file_size = $file['size'];
    
    if (!in_array($file_ext, $allowed_exts)) {
        return "Extension non autorisée.";
    }
    
    if ($file_size > $max_size) {
        return "Fichier trop volumineux.";
    }
    
    return true;
}

// Créer un nom de fichier unique en utilisant le nom du demandeur et un identifiant unique
function create_unique_filename($directory, $filename) {
    $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
    $base_name = pathinfo($filename, PATHINFO_FILENAME);
    $new_filename = $base_name . '.' . $file_ext;
    $counter = 1;

    while (file_exists($directory . $new_filename)) {
        $new_filename = $base_name . '_' . $counter . '.' . $file_ext;
        $counter++;
    }

    return $new_filename;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération et sécurisation des données du formulaire
    $nomDemandeur = secure_input($_POST['nomDemandeur']);
    $prenomsDemandeur = secure_input($_POST['prenomsDemandeur']);
    $genre = secure_input($_POST['genre']);
    $emailDemandeur = secure_input($_POST['emailDemandeur']);
    $dateNaissance = secure_input($_POST['dateNaissance']);
    $lieuNaissance = secure_input($_POST['lieuNaissance']);
    $nationaliteDemandeur = secure_input($_POST['nationaliteDemandeur']);
    $numeropiece = secure_input($_POST['numeropiece']);
    $debutstage = secure_input($_POST['debutstage']);
    $finstage = secure_input($_POST['finstage']);
    $telephone = secure_input($_POST['telephone']);
    $dateDemande = secure_input($_POST['dateDemande']);
    $idSpecialite = secure_input($_POST['idSpecialite']);
    $idNiveau = secure_input($_POST['idNiveau']);
    $idEcole = secure_input($_POST['idEcole']);
    $dureestage = isset($_POST['dureestage']) ? secure_input($_POST['dureestage']) : '';

    // Validation du numéro de téléphone
    if (!preg_match("/^\+225[0-9]{10}$/", $telephone)) {
        die("Numéro de téléphone invalide. Il doit contenir l'indicatif du pays (+225) suivi de 10 chiffres.");
    }

    // Validation et gestion des fichiers uploadés
    $allowed_exts = ['jpg', 'jpeg', 'png', 'pdf'];
    $max_file_size = 5 * 1024 * 1024; // 5 MB

    $photo = $_FILES['photo'];
    $diplomeDemandeur = $_FILES['diplomeDemandeur'];
    $cvDemandeur = $_FILES['cvDemandeur'];
    $cniDemandeur = $_FILES['cniDemandeur'];
    $lettreDemandeur = $_FILES['lettreDemandeur'];

    $photo_result = validate_file($photo, $allowed_exts, $max_file_size);
    $diplome_result = validate_file($diplomeDemandeur, $allowed_exts, $max_file_size);
    $cv_result = validate_file($cvDemandeur, $allowed_exts, $max_file_size);
    $cni_result = validate_file($cniDemandeur, $allowed_exts, $max_file_size);
    $lettre_result = validate_file($lettreDemandeur, $allowed_exts, $max_file_size);

    if ($photo_result !== true || $diplome_result !== true || $cv_result !== true || $cni_result !== true || $lettre_result !== true) {
        die("Erreur de validation des fichiers : $photo_result $diplome_result $cv_result $cni_result $lettre_result");
    }

    // Démarrer une transaction
    $conn->begin_transaction();

    try {
        $upload_dir = 'uploads/';
        
        // Modifier le nom des fichiers pour inclure le nom du demandeur et le numéro de la pièce
        $base_filename = $nomDemandeur . '_' . $numeropiece;
        
        $photo_filename = $base_filename . '_photo.' . pathinfo($photo['name'], PATHINFO_EXTENSION);
        $diplome_filename = $base_filename . '_diplome.' . pathinfo($diplomeDemandeur['name'], PATHINFO_EXTENSION);
        $cv_filename = $base_filename . '_cv.' . pathinfo($cvDemandeur['name'], PATHINFO_EXTENSION);
        $cni_filename = $base_filename . '_cni.' . pathinfo($cniDemandeur['name'], PATHINFO_EXTENSION);
        $lettre_filename = $base_filename . '_lettre.' . pathinfo($lettreDemandeur['name'], PATHINFO_EXTENSION);

        // Générer des noms de fichiers uniques
        $photo_path = $upload_dir . create_unique_filename($upload_dir, $photo_filename);
        $diplome_path = $upload_dir . create_unique_filename($upload_dir, $diplome_filename);
        $cv_path = $upload_dir . create_unique_filename($upload_dir, $cv_filename);
        $cni_path = $upload_dir . create_unique_filename($upload_dir, $cni_filename);
        $lettre_path = $upload_dir . create_unique_filename($upload_dir, $lettre_filename);

        // Insertion des données dans la base de données
        $sql = "INSERT INTO DEMANDEURS (nomDemandeur, prenomsDemandeur, genre, emailDemandeur, dateNaissance, lieuNaissance, 
            nationaliteDemandeur, numeropiece, debutstage, finstage, dureestage, telephone, dateDemande, photo, diplomeDemandeur, 
            cvDemandeur, cniDemandeur, lettreDemandeur, idSpecialite, idNiveau, idEcole) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param( "sssssssssssssssssssss", 
            $nomDemandeur, $prenomsDemandeur, $genre, $emailDemandeur, $dateNaissance, $lieuNaissance, $nationaliteDemandeur, 
            $numeropiece, $debutstage, $finstage, $dureestage, $telephone, $dateDemande, $photo_path, $diplome_path, $cv_path, 
            $cni_path, $lettre_path, $idSpecialite, $idNiveau, $idEcole );

        if (!$stmt->execute()) {
            throw new Exception("Erreur lors de l'insertion des données : " . $stmt->error);
        }

        // Déplacer les fichiers uploadés vers le répertoire de destination
        if (!move_uploaded_file($photo['tmp_name'], $photo_path) ||
            !move_uploaded_file($diplomeDemandeur['tmp_name'], $diplome_path) ||
            !move_uploaded_file($cvDemandeur['tmp_name'], $cv_path) ||
            !move_uploaded_file($cniDemandeur['tmp_name'], $cni_path) ||
            !move_uploaded_file($lettreDemandeur['tmp_name'], $lettre_path)) {
            throw new Exception("Erreur lors du déplacement des fichiers.");
        }

        // Valider la transaction
        $conn->commit();
        echo "Données insérées avec succès.";

    } catch (Exception $e) {
        // Annuler la transaction
        $conn->rollback();

        // Supprimer les fichiers téléchargés en cas d'erreur
        @unlink($photo_path);
        @unlink($diplome_path);
        @unlink($cv_path);
        @unlink($cni_path);
        @unlink($lettre_path);

        // Afficher l'erreur
        die("Erreur : " . $e->getMessage());
    }

    $stmt->close();
}

// Fermer la connexion
$conn->close();
?>