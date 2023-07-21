<?php

// Définition de l'espace de noms pour notre formulaire.
namespace Drupal\newsletter_subscription\Form;

// Importation des classes nécessaires pour la création du formulaire.
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Implements a newsletter subscription form.
 */
class NewsletterSubscriptionForm extends FormBase {

  /**
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  // Déclaration d'une propriété pour le service messenger.
  protected $messenger;

  /**
   * Class constructor.
   */
  // Le constructeur récupère le service messenger de Drupal.
  public function __construct(MessengerInterface $messenger) {
    $this->messenger = $messenger;
  }

  /**
   * {@inheritdoc}
   */
  // La méthode create() permet de créer une instance de notre classe avec les dépendances injectées.
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('messenger')
    );
  }

  /**
   * {@inheritdoc}
   */
  // getFormId() retourne l'ID unique de notre formulaire.
  public function getFormId() {
    return 'newsletter_subscription_form';
  }

  /**
   * {@inheritdoc}
   */
  // buildForm() définit la structure de notre formulaire.
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Civilité - Sélection
    $form['civility'] = [
      '#type' => 'select',
      '#title' => $this->t('Civilité'),
      '#options' => [
        'Monsieur' => $this->t('Monsieur'),
        'Madame' => $this->t('Madame'),
      ],
      '#required' => TRUE,
    ];
    // Nom - Champ texte
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Nom'),
      '#required' => TRUE,
    ];
    // Email - Champ email
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Adresse mail'),
      '#required' => TRUE,
    ];
    // Bouton de soumission du formulaire
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  // validateForm() effectue une vérification de validité de l'email.
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (!filter_var($form_state->getValue('email'), FILTER_VALIDATE_EMAIL)) {
      $form_state->setErrorByName('email', $this->t('L'adresse  %email n'est pas valide.', ['%email' => $form_state->getValue('email')]));
    }
  }

  /**
   * {@inheritdoc}
   */
  // submitForm() effectue l'action de soumission du formulaire. Ici, on crée un nouveau noeud avec les données du formulaire.
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Création d'un nouveau noeud
    $node = Node::create([
      'type' => 'subscription_newsletter',
      'title' => $form_state->getValue('name'),
      'field_civility' => $form_state->getValue('civility'),
      'field_email' => $form_state->getValue('email'),
    ]);
    // Enregistrement du noeud
    $node->save();

    // Affichage d'un message de succès
    $this->messenger->addStatus($this->t('Votre inscription a bien été prise en compte.'));

    // Redirection vers la page d'accueil
    $form_state->setRedirect('<front>');
  }
}
