## 🏗️ Technical Implementation Plan: Blog Platform

### ✅ Phase A: Foundation & Architecture (Status: INITIALIZATION)
*Setting up the secure environment and data structure.*

*Logic Flow:*
1.  **First**, initialize the Laravel project and install **Laravel Breeze** (Livewire stack) to handle all Authentication scaffolding (Login, Register, Password Reset).
2.  **Then**, define the **Database Schema**:
    *   `users`: Standard Laravel Auth table.
    *   `posts`: `id`, `user_id` (foreign), `title`, `slug` (for URL), `content`, `published_at`, `timestamps`.
    *   `comments`: `id`, `post_id`, `user_id`, `body`, `timestamps`.
    *   `likes`: `id`, `user_id`, `post_id`. (Compound unique index on `user_id` + `post_id` to prevent duplicate likes).
3.  **Finally**, define **Eloquent Relationships** in Models:
    *   `User` hasMany `Post`, `Comment`, `Like`.
    *   `Post` belongsTo `User`, hasMany `Comment`, hasMany `Like`.

**📂 Files to Create/Modify:**
*   `database/migrations/xxxx_create_posts_table.php`
*   `database/migrations/xxxx_create_comments_table.php`
*   `database/migrations/xxxx_create_likes_table.php`
*   `app/Models/Post.php`
*   `app/Models/Comment.php`
*   `app/Models/Like.php`

---

### 🚧 Phase B: "My Posts" Dashboard (Status: PENDING)
*The Authoring Experience. CRUD operations protected by Ownership.*

*Logic Flow:*
1.  **First**, create the **PostPolicy** (`php artisan make:policy PostPolicy`).
    *   Define `update` and `delete` methods: `return $user->id === $post->user_id;`.
2.  **Then**, build the **Manage Posts** Livewire Component (The "Resource"):
    *   **Listing:** Fetch `Auth::user()->posts()->paginate()`.
    *   **Create:** A modal or form to validate and save a new post.
    *   **Edit:** Bind a post to the form. **Check Policy:** `$this->authorize('update', $post)`.
    *   **Delete:** **Check Policy:** `$this->authorize('delete', $post)` before destroying.
3.  **Finally**, register the route in `routes/web.php` protected by the `auth` middleware.

**📂 Files:**
*   `app/Policies/PostPolicy.php`
*   `app/Livewire/Dashboard/MyPosts.php` (Listing & Delete logic)
*   `app/Livewire/Dashboard/PostForm.php` (Create & Update logic)
*   `resources/views/livewire/dashboard/my-posts.blade.php`

---

### Phase C: Public Access & Reading (The "View" Layer)
*Logic Flow:*
1.  **First**, create a Public Landing Page.
    *   Fetch all posts where `published_at` is not null.
    *   Order by latest.
2.  **Then**, create the **Single Post View**.
    *   Use Route Model Binding with Slugs for SEO (`/posts/{post:slug}`).
    *   Display Title, Author Name, Date, and Content.
3.  **Finally**, implement the "Guest vs Auth" view logic:
    *   If the viewer is the *owner*, show "Edit" buttons on the public page.
    *   If the viewer is *guest*, show only content.

**📂 Files:**
*   `app/Livewire/Public/BlogIndex.php`
*   `app/Livewire/Public/ShowPost.php`
*   `resources/views/livewire/public/blog-index.blade.php`
*   `resources/views/livewire/public/show-post.blade.php`

---

### Phase D: Engagement (Comments & Likes)
*Logic Flow:*
1.  **First**, implement **Likes** (Livewire Component).
    *   **Check:** Is user logged in? If no, redirect to login.
    *   **Action:** Toggle relationship. `auth()->user()->likes()->toggle($post)`.
    *   **UI:** Optimistic update (update count immediately via Alpine/Livewire).
2.  **Then**, implement **Comments**.
    *   List existing comments for the post.
    *   Add a form: `textarea` + `Submit`.
    *   **Validation:** Required, max characters.
    *   **Security:** Ensure `post_id` matches the current page.
3.  **Finally**, add "Delete Comment" ability.
    *   Only allow if `auth()->id() === comment->user_id` OR `auth()->id() === post->user_id`.

**📂 Files:**
*   `app/Livewire/Components/LikeButton.php`
*   `app/Livewire/Components/CommentSection.php`
*   `resources/views/livewire/components/comment-section.blade.php`

---

## 📝 Immediate Action Plan (Starting Phase A)

1.  **Install Laravel Breeze** to handle the auth scaffolding immediately.
2.  **Generate Migrations** for Posts, Comments, and Likes.
3.  **Define Models** to ensure relationships (`$user->posts`) are ready for the logic phase.

Shall we begin by running the **Migrations** and setting up the **Models**?