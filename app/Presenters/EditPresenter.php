<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;

final class EditPresenter extends Nette\Application\UI\Presenter
{
  public function __construct(
    private Nette\Database\Explorer $database,
  ) {
  }

  protected function createComponentPostForm(): Form
  {
    $form = new Form;
    $form->addText('title', 'Titulek:')
      ->setRequired();
    $form->addTextArea('content', 'Obsah:')
      ->setRequired();

    $form->addSubmit('send', 'Uložit a publikovat');
    $form->onSuccess[] = $this->postFormSucceeded(...);

    return $form;
  }

 private function postFormSucceeded(array $data): void
{
	$post = $this->database
		->table('posts')
		->insert($data);

	$this->flashMessage("Příspěvek byl úspěšně publikován.", 'success');
	$this->redirect('Post:show', $post->id);
}

}