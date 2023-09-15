<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;

final class PostPresenter extends Nette\Application\UI\Presenter
{
  public function __construct(
    private Nette\Database\Explorer $database,
  ) {
  }

  public function renderShow(int $postId): void
  {
    $post = $this->database
      ->table('posts')
      ->get($postId);
    if (!$post) {
      $this->error('Stránka nebyla nalezena');
    }

    $this->template->post = $post;
    $this->template->comments = $post->related('comments')->order('created_at DESC'); //DESC neseřadilo komentáře sestupně - proč?
  }

  protected function createComponentCommentForm(): Form
  {
    $form = new Form; // means Nette\Application\UI\Form

    $form->addText('name', 'Jméno:')
      ->setRequired();

    $form->addEmail('email', 'E-mail:');

    $form->addTextArea('content', 'Komentář:')
      ->setRequired();

    $form->addSubmit('send', 'Publikovat komentář');

    $form->onSuccess[] = $this->commentFormSucceeded(...);

    return $form;
  }

  private function commentFormSucceeded(\stdClass $data): void
  {
    $postId = $this->getParameter('postId');

    $this->database->table('comments')->insert([
      'post_id' => $postId,
      'name' => $data->name,
      'email' => $data->email,
      'content' => $data->content,
      'created_at' =>new \DateTime()
    ]);
    \tracy\Debugger::barDump(new \DateTime());

    $this->flashMessage('Děkuji za komentář', 'success');
    $this->redirect('this');
  }
}
