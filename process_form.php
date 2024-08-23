<?php
// Afficher les erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
        return "Extension non autorisée : " . $file_ext;
    }
    
    if ($file_size > $max_size) {
        return "Fichier trop volumineux : " . $file['name'];
    }
    
    return true;
}

// Créer un nom de fichier unique en utilisant l'ID du demandeur
function create_unique_filename($directory, $idDemandeur, $filename) {
    $file_ext = pathinfo($filename, PATHINFO_EXTENSION);
    $new_filename = $idDemandeur . '_' . $filename;
    $counter = 1;

    while (file_exists($directory . $new_filename)) {
        $new_filename = $idDemandeur . '_' . pathinfo($filename, PATHINFO_FILENAME) . '_' . $counter . '.' . $file_ext;
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
    $dureestage = secure_input($_POST['dureestage']);
    $telephone = secure_input($_POST['telephone']);
    $dateDemande = secure_input($_POST['dateDemande']);
    $idSpecialite = secure_input($_POST['idSpecialite']);
    $idNiveau = secure_input($_POST['idNiveau']);
    $idEcole = secure_input($_POST['idEcole']);
    $idTypestage = secure_input($_POST['idTypestage']); // Ajout de idTypeStage

    // Validation du numéro de téléphone
    if (!preg_match("/^\+225[0-9]{10}$/", $telephone)) {
        die("Numéro de téléphone invalide. Il doit contenir l'indicatif du pays (+225) suivi de 10 chiffres.");
    }

    // Validation et gestion des fichiers uploadés
    $allowed_exts = ['jpg', 'jpeg', 'png', 'pdf'];
    $max_file_size = 5 * 1024 * 1024; // 5 MB

    $files = [
        'photo' => $_FILES['photo'],
        'diplomeDemandeur' => $_FILES['diplomeDemandeur'],
        'cvDemandeur' => $_FILES['cvDemandeur'],
        'cniDemandeur' => $_FILES['cniDemandeur'],
        'lettreDemandeur' => $_FILES['lettreDemandeur']
    ];

    $upload_directory = "uploads/";

    // Démarrer une transaction
    $conn->begin_transaction();

    try {
        // Insérer les données dans la table DEMANDEURS
        $stmt = $conn->prepare("INSERT INTO DEMANDEURS (nomDemandeur, prenomsDemandeur, genre, emailDemandeur, dateNaissance, lieuNaissance, nationaliteDemandeur, numeropiece, debutstage, dureestage, telephone, dateDemande, idSpecialite, idNiveau, idEcole, idTypestage) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            throw new Exception("Erreur lors de la préparation de la requête : " . $conn->error);
        }
        $stmt->bind_param("ssssssssssssssss", $nomDemandeur, $prenomsDemandeur, $genre, $emailDemandeur, $dateNaissance, $lieuNaissance, $nationaliteDemandeur, $numeropiece, $debutstage, $dureestage, $telephone, $dateDemande, $idSpecialite, $idNiveau, $idEcole, $idTypestage);

        if (!$stmt->execute()) {
            throw new Exception("Erreur lors de l'insertion des données : " . $stmt->error);
        }

        // Obtenir l'ID du demandeur
        $idDemandeur = $stmt->insert_id;

        // Créer un nom de fichier unique et déplacer les fichiers uploadés
        $filePaths = [];
        foreach ($files as $key => $file) {
            if ($file['error'] === UPLOAD_ERR_OK) {
                $validation_result = validate_file($file, $allowed_exts, $max_file_size);
                if ($validation_result !== true) {
                    throw new Exception("Erreur de validation du fichier " . $key . ": " . $validation_result);
                }

                // Créer un nom de fichier unique avec l'ID du demandeur
                $filename = create_unique_filename($upload_directory, $idDemandeur, $file['name']);
                $filepath = $upload_directory . $filename;

                if (!move_uploaded_file($file['tmp_name'], $filepath)) {
                    throw new Exception("Erreur lors du téléchargement du fichier " . $key . ".");
                }

                // Stocker le chemin du fichier pour mise à jour dans la base de données
                $filePaths[$key] = $filepath; // Enregistrer le chemin complet
            } else {
                throw new Exception("Erreur lors du téléchargement du fichier " . $key . ": " . $file['error']);
            }
        }

        // Les chemins des fichiers dans la table DEMANDEURS
        $stmt_update = $conn->prepare("UPDATE DEMANDEURS SET photo = ?, diplomeDemandeur = ?, cvDemandeur = ?, cniDemandeur = ?, lettreDemandeur = ? WHERE idDEMANDEUR = ?");
        if ($stmt_update === false) {
            throw new Exception("Erreur lors de la préparation de la requête de mise à jour : " . $conn->error);
        }
        $stmt_update->bind_param("sssssi", $filePaths['photo'], $filePaths['diplomeDemandeur'], $filePaths['cvDemandeur'], $filePaths['cniDemandeur'], $filePaths['lettreDemandeur'], $idDemandeur);

        if (!$stmt_update->execute()) {
            throw new Exception("Erreur lors de la mise à jour des chemins de fichiers : " . $stmt_update->error);
        }

        // Commit transaction
        $conn->commit();
        echo "Demande soumise avec succès !";

    } catch (Exception $e) {
        // Rollback transaction en cas d'erreur
        $conn->rollback();
        die("Erreur : " . $e->getMessage());
    } finally {
        // Fermeture des ressources
        if (isset($stmt)) {
            $stmt->close();
        }
        if (isset($stmt_update)) {
            $stmt_update->close();
        }
        $conn->close();
    }
}
?>
