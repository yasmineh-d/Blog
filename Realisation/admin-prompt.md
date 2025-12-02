# ✅ **Prompt – Generate Admin Section for Blog Module**

Generate the **admin interface of a blog management module** using **Laravel**, **Blade**, **TailwindCSS**, and a **layered architecture Controller → Service → Model**.

## 🎯 **Context**

You are building a simple **back-office (admin section) without authentication**.
All articles are automatically assigned to an existing **Admin user** in the database.

Use the following architecture:

* **Controller Layer**

  * Handles HTTP routes: list, create, edit, delete.
  * Calls `ArticleService`.
  * No business logic.

* **Service Layer (ArticleService)**

  * Business logic:

    * CRUD articles
    * assign admin user
    * apply filters (search, category, status)
    * prepare pagination
    * sync categories
  * Returns data prepared for the view.

* **Models**

  * `Article`, `Category`, `User`

* **Relations**

  * Article ↔ Category (many-to-many)
  * Article ↔ User (many-to-one)

---

# 🛠️ **Your Task**

Generate the full **admin section** of the blog, including:

---

## ✔️ **1. Admin Routes (`/admin/articles/*`)**

Use Laravel route resource or manual routes:

* GET `/admin/articles` → list with filters + pagination
* GET `/admin/articles/create`
* POST `/admin/articles`
* GET `/admin/articles/{id}/edit`
* PUT `/admin/articles/{id}`
* DELETE `/admin/articles/{id}` with JS confirm popup

---

## ✔️ **2. Controller : `Admin/ArticleController`**

* No logic inside
* Call methods from `ArticleService`

  * index()
  * store()
  * update()
  * delete()
* Pass data to Blade views

---

## ✔️ **3. Service : `Services/ArticleService.php`**

Methods to generate:

* `getArticles($filters)`
  Apply:

  * search
  * category filter
  * status filter (optional)
  * sort by date desc
  * return paginated data

* `createArticle($request)`

  * assign admin user
  * save article
  * sync categories

* `updateArticle($request, $article)`

  * update fields
  * sync categories

* `deleteArticle($article)`

* automatically load default Admin:

  ```php
  $admin = User::where('role','admin')->first();
  ```

---

## ✔️ **4. Blade Admin Pages**

Use **TailwindCSS**.

### a. `/admin/articles/index.blade.php`

Contains:

* List of articles:

  * ID
  * Title
  * Categories
  * Status
  * Created date
  * Delete button with JS confirm
* Filters:

  * Search text
  * Category select or category links
* Pagination (newest first)

### b. `/admin/articles/create.blade.php`

### c. `/admin/articles/edit.blade.php`

Both forms must include:

* Title (text)
* Content with **Summernote**
* Status (draft / published)
* Multi-select or checkboxes for categories
* Submit button

Add client-side Summernote init script in Blade.

---

## ✔️ **5. Summernote Integration**

Generate:

* Scripts & CSS includes
* JavaScript to initialize Summernote:

  ```js
  $('#content').summernote({
      height: 250,
  });
  ```

Store the HTML in the database.

---

## ✔️ **6. Database**

Use existing tables:

* `articles`
* `categories`
* `users`

Pivot table:

```
article_category (article_id, category_id)
```

---

## ✔️ **7. Output Format**

Deliver:

* Laravel routes
* Controllers
* Service file
* Blade templates
* JS confirm for delete
* Tailwind classes
* Validation rules
* Example Eloquent queries
* Pagination component

💡 Focus only on **the Admin section** (no public pages).

---

# 🔥 Expected Result

A complete admin module ready to integrate into the project, structured exactly following:

```
Controller → Service → Model
```

with:

* CRUD
* rich text editor
* multi-category assignment
* filters
* pagination
* delete confirmation
* automatic admin author assignment

---

