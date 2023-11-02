<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\BulkDestroyPost;
use App\Http\Requests\Admin\Post\DestroyPost;
use App\Http\Requests\Admin\Post\IndexPost;
use App\Http\Requests\Admin\Post\StorePost;
use App\Http\Requests\Admin\Post\UpdatePost;
use App\Models\Post;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

use App\Models\Category;
use App\Models\CategoryHasPost;

class PostController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexPost $request
     * @return array|Factory|View
     */
    public function index(IndexPost $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Post::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'title', 'description'],

            // set columns to searchIn
            ['id', 'title', 'description'],

            function ($query) use ($request) {
                /*
                $query->with(['author']);
    
                // add this line if you want to search by author attributes
                $query->join('authors', 'authors.id', '=', 'articles_with_relationships.author_id');
    
                if($request->has('authors')){
                    $query->whereIn('author_id', $request->get('authors'));
                }
                */

                $query->with(['categories']);

                if($request->has('categories')){

                    $post_ids = CategoryHasPost::whereIn('category_id',$request->get('categories'))
                    ->get()
                    ->map(function($item){
                        return $item->post_id;
                    });
                    $query->whereIn('id', $post_ids);
                }
            }
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.post.index', [
            'data' => $data,
            'categories' => Category::richList()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.post.create');        

        return view('admin.post.create', [
            'post' => new Post,
            'categories' => Category::richList()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePost $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StorePost $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();        

        // Store the Post
        $post = Post::create($sanitized);             

        if (array_key_exists('categories', $sanitized)) {
            $categories_has_posts = collect($sanitized['categories'])
            ->map(function ($item)  use ($post) {

                $category_id = Category::inRandomOrder()->first()->id;
                return [
                    'post_id' => $post->id,
                    'category_id' => $item
                ];
            })
            ->toArray();

            CategoryHasPost::create($categories_has_posts);
        }

        if ($request->ajax()) {
            return ['redirect' => url('admin/posts'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @throws AuthorizationException
     * @return void
     */
    public function show(Post $post)
    {
        $this->authorize('admin.post.show', $post);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Post $post
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Post $post)
    {
        $this->authorize('admin.post.edit', $post);

        $post->categories = CategoryHasPost::getPostCategories($post->id);

        return view('admin.post.edit', [
            'post' => $post,
            'categories' => Category::richList()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePost $request
     * @param Post $post
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdatePost $request, Post $post)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        if (array_key_exists('categories', $sanitized)) {
            CategoryHasPost::where('post_id', $post->id)->delete();

            $categories_has_posts = collect($sanitized['categories'])
            ->map(function ($item)  use ($post) {
                $category_id = Category::inRandomOrder()->first()->id;
                return [
                    'post_id' => $post->id,
                    'category_id' => $item
                ];
            })
            ->toArray();
            CategoryHasPost::insert($categories_has_posts);           
        }

        // Update changed values Post
        $post->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/posts'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyPost $request
     * @param Post $post
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyPost $request, Post $post)
    {
        CategoryHasPost::where('post_id', $post->id)->delete();

        $post->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyPost $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyPost $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    CategoryHasPost::whereIn('post_id', $bulkChunk)->delete();

                    Post::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
