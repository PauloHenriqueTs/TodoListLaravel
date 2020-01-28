<?php

namespace Tests\Unit;

use App\Todo;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodosControllerTest extends TestCase
{
    use RefreshDatabase;

    private function todoTest(){
        return [
            'name' => '1234567',
        'description' => 'description'
        
        ];
    }

    /** @test */
    public function TodoModel_Create_Successful()
    {
        $todo =  factory(Todo::class)->create();
        $this->assertCount(1, Todo::all()); 
        $this->assertEquals($todo->id, Todo::first()->id);
    }
     /** @test */
     public function index_GetTodos_ReturnTodo()
     {
         $todo =  factory(Todo::class)->create();
         $response = $this->get('/todos');
         $response->assertSeeText($todo->name);
       //  dd($response->getContent());
     }
       /** @test */
     public function todos_Post_Successful()
     {
        $todo = $this->todoTest();
         $response = $this->post('/store-todos',$todo);
         $this->assertEquals($todo['name'], Todo::first()->name);
      $response->assertRedirect('/todos');
     }
        /** @test */
        public function todos_Delete_Successful()
        {
            $todo =  factory(Todo::class)->create();
            $this->assertCount(1, Todo::all()); 
            $response = $this->get("/todos/ $todo->id /delete" );
            $this->assertCount(0, Todo::all()); 
         $response->assertRedirect('/todos');
        }

         /** @test */
         public function todos_Edit_Successful()
         {
             $todo =  factory(Todo::class)->create();
             
             
             $todotest = $this->todoTest();
            $response = $this->post("todos/1/update-todos",$todotest);
            $this->assertEquals($todotest['name'], Todo::first()->name);
            $response->assertRedirect('/todos');
         }

     
}
