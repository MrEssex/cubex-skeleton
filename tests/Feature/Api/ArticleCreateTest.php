<?php
namespace CubexBase\Tests\Feature\Api;

use CubexBase\Tests\TestCase;
use JsonException;
use Throwable;

class ArticleCreateTest extends TestCase
{
  /**
   * @return void
   * @throws JsonException
   * @throws Throwable
   */
  public function test_it_returns_the_article_on_successful_creation_of_new_article(): void
  {
    $data = [
      'article' => [
        'title' => 'Test Article',
        'body'  => 'This is a test article',
      ],
    ];

    $response = $this->postJson('/api/articles', $data, $this->_headers);

    $response->assertStatus(200);

    $data['article']['tags'] = ['test', 'article'];

    $response = $this->postJson('/api/articles', $data, $this->_headers);

    $response->assertStatus(200);
  }
}
