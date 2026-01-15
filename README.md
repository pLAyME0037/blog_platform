Here is the **Updated Implementation Plan** incorporating the **Multiple Images** requirement while maintaining the **5-Person Team Split** and **Traditional Blade** approach.

---

## 🏗️ 5-Person Technical Plan (Updated for Multi-Image Support)

### 🚀 Step 1: The "Shared Foundation" (Dev 1 - The Lead)
*Before the team splits, Dev 1 must set up the core.*
*   **Install:** Laravel + Breeze (Blade stack).
*   **Database:** Create `users`, `posts`, `post_images`, `comments`, `likes` tables.
*   **Storage:** Run `php artisan storage:link` (Critical for images to show up).
*   **Seeders:** Run the `DatabaseSeeder` so everyone has data.
*   **Git:** Push `main`.

---

### 🧱 Step 2: Divide & Conquer (5 Roles)

#### 👮‍♂️ Dev 1: Architecture & Access (Lead / Security)
*The Guard. Handles the setup, navigation, and database structure.*
*   **Task:** Define Layouts, Navigation, Middleware, and the **Image Migration**.
*   **Database Change:** Create `create_post_images_table` migration:
    *   Columns: `id`, `post_id` (foreign key), `image_path` (string).
*   **Files:**
    *   `database/migrations/xxxx_create_post_images_table.php`
    *   `app/Models/PostImage.php` (BelongsTo Post)
    *   `app/Models/Post.php` (HasMany PostImage)
    *   `resources/views/layouts/app.blade.php`

#### 📝 Dev 2: Post Management (The Author)
*The CRUD Expert. Handles the "Back Office" & File Uploads.*
*   **Task:** Build the system to write posts and **upload multiple photos**.
*   **Controller:** `DashboardPostController`.
*   **Logic (File Uploads):**
    *   **Form:** Must use `<form enctype="multipart/form-data">`.
    *   **Input:** `<input type="file" name="images[]" multiple>`.
    *   **Store Method:** Loop through `$request->file('images')`, store them in `public/posts`, and save paths to the `post_images` table.
*   **Views:**
    *   `views/dashboard/posts/create.blade.php` (The generic form)

#### 👓 Dev 3: Public Reading (The Viewer)
*The Frontend. Handles the public facing pages & Gallery.*
*   **Task:** Display posts and the **Image Gallery**.
*   **Controller:** `PublicPostController`.
*   **Views:**
    *   `views/posts/show.blade.php`
*   **Logic (Gallery):**
    *   Check if `$post->images` is not empty.
    *   Loop through images: `<img src="{{ asset('storage/' . $image->image_path) }}">`.
    *   Use CSS Grid or Flexbox to display them nicely.

#### 🗣️ Dev 4: Interaction System (The Commenter)
*The Community Manager. Handles discussion.*
*   **Task:** Allow users to comment on Dev 3's posts.
*   **Controller:** `CommentController` (Methods: `store`, `destroy`).
*   **Integration:** Build a **Partial View** (`_comments.blade.php`) included by Dev 3.
*   **Logic:**
    *   Form POST request to `/posts/{post}/comments`.
    *   Validation: Required, Max 1000 chars.

#### ❤️ Dev 5: Social & Profile (The User)
*The Social Engineer. Handles Likes and Profile aggregation.*
*   **Task:** The "Like" button logic and "My Liked Posts" page.
*   **Controller:** `LikeController` & `ProfileController`.
*   **Logic:**
    *   **Like:** Form POST that redirects back (Page reload).
    *   **Profile:** Page showing "Posts I have liked" (`Auth::user()->likedPosts`).
*   **Views:**
    *   `views/profile/liked-posts.blade.php`

---

### 🔧 Low-Level Rules of Engagement

#### 1. The "Controller" Rule
**Never** put all logic in one Controller.
*   Dev 2 owns `DashboardPostController`.
*   Dev 3 owns `PublicPostController`.
*   Dev 4 owns `CommentController`.
*   Dev 5 owns `LikeController`.

#### 2. The "Upload" Rule (Specific for Dev 2)
To handle multiple images without complexity:
```php
// DashboardPostController.php
public function store(Request $request) {
    // 1. Create Post
    $post = Auth::user()->posts()->create($request->safe()->except('images'));
    
    // 2. Handle Images
    if($request->hasFile('images')) {
        foreach($request->file('images') as $file) {
            $path = $file->store('posts', 'public'); // Save file
            $post->images()->create(['image_path' => $path]); // Save DB record
        }
    }
}
```

#### 3. The "Route" Rule
Split `routes/web.php` clearly:

```php
// --- Dev 3 (Public) ---
Route::get('/', [PublicPostController::class, 'index']);
Route::get('/posts/{post}', [PublicPostController::class, 'show']);

// --- Authenticated Group ---
Route::middleware(['auth'])->group(function () {
    // Dev 2 (Dashboard)
    Route::resource('dashboard/posts', DashboardPostController::class);

    // Dev 4 (Comments)
    Route::post('/posts/{post}/comments', [CommentController::class, 'store']);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);

    // Dev 5 (Likes & Profile)
    Route::post('/posts/{post}/like', [LikeController::class, 'toggle']);
    Route::get('/my-likes', [ProfileController::class, 'likes']);
});
```

### 🏁 Summary Checklist

1.  **Dev 1:** Run `php artisan make:model PostImage -m` immediately.
2.  **Dev 1:** Run `php artisan storage:link`.
3.  **Dev 2:** Remember to add `enctype="multipart/form-data"` to your HTML form, or uploads will silently fail.
4.  **Dev 3:** Remember to use `asset('storage/' . $path)` to display images.