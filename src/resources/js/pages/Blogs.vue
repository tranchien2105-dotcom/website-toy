<script setup>
import { ref, onMounted, watch } from 'vue'
import axios from '../axios'
import { useRouter } from 'vue-router'

const router = useRouter()

const blogs = ref([])

const perPage = ref(6)

const currentPage = ref(1)
const lastPage = ref(1)

const search = ref('')
const category = ref('')
const status = ref('')

const loading = ref(false)

/*
|--------------------------------------------------------------------------
| Get Blogs
|--------------------------------------------------------------------------
*/

const getBlogs = async (page = 1) => {

    try {

        loading.value = true

        const response = await axios.get(
            '/api/blogs',
            {
                params: {
                    page: page,
                    per_page: perPage.value,
                    search: search.value,
                    category: category.value,
                    status: status.value
                }
            }
        )

        blogs.value = response.data.data

        currentPage.value =
            response.data.current_page

        lastPage.value =
            response.data.last_page

    } catch (error) {

        console.error(error)

    } finally {

        loading.value = false

    }

}

/*
|--------------------------------------------------------------------------
| Change Page
|--------------------------------------------------------------------------
*/

const changePage = (page) => {

    if (
        page < 1 ||
        page > lastPage.value
    ) return

    getBlogs(page)

}

/*
|--------------------------------------------------------------------------
| Edit Blog
|--------------------------------------------------------------------------
*/

const editBlog = (blog) => {

    router.push(
        `/blogs/${blog.id}`
    )

}

/*
|--------------------------------------------------------------------------
| Delete Blog
|--------------------------------------------------------------------------
*/

const deleteBlog = (blog) => {

    if (
        confirm(
            `Bạn có chắc muốn xóa bài viết "${blog.title}"?`
        )
    ) {

        axios.delete(
            `/api/blogs/${blog.id}`
        )
            .then((response) => {

                alert(
                    response.data.message
                )

                getBlogs(
                    currentPage.value
                )

            })
            .catch((error) => {

                console.error(error)

                alert(
                    error.response.data.message
                )

            })

    }

}

/*
|--------------------------------------------------------------------------
| Watch Filter
|--------------------------------------------------------------------------
*/

watch(

    [
        search,
        category,
        status,
        perPage
    ],

    () => {

        getBlogs()

    }

)

/*
|--------------------------------------------------------------------------
| Mounted
|--------------------------------------------------------------------------
*/

onMounted(() => {

    getBlogs()

})

</script>

<template>

    <div class="blog-page">

        <div class="page-header">

            <h1>Quản lý Blog</h1>

            <button class="add-btn" @click="router.push('/blogs/create')">
                + Thêm Blog
            </button>

        </div>

        <!-- Toolbar -->

        <div class="toolbar">

            <input v-model="search" class="input" type="text" placeholder="🔍 Tìm tiêu đề...">

            <input v-model="category" class="input" type="text" placeholder="Danh mục...">

            <select v-model="status" class="select">

                <option value="">
                    Tất cả trạng thái
                </option>

                <option value="Draft">
                    Draft
                </option>

                <option value="Published">
                    Published
                </option>

                <option value="Archived">
                    Archived
                </option>

            </select>

            <select v-model="perPage" class="select">

                <option :value="5">5</option>

                <option :value="10">10</option>

                <option :value="20">20</option>

            </select>

        </div>

        <!-- Loading -->

        <div v-if="loading" class="loading">

            Đang tải dữ liệu...

        </div>

        <!-- Table -->

        <table v-else class="table">

            <thead>

                <tr>

                    <th>Ảnh</th>

                    <th>Tiêu đề</th>

                    <th>Danh mục</th>

                    <th>Người tạo</th>

                    <th>Thời gian hiện</th>

                    <th>Trạng thái</th>

                    <th>Sửa</th>

                </tr>

            </thead>

            <tbody>

                <tr v-for="blog in blogs" :key="blog.id">

                    <td>

                        <img :src="`/layout/images/blogs/${blog.image}`" class="thumb">

                    </td>

                    <td>
                        <strong>{{ blog.title }}</strong>
                        <div class="description" v-html="blog.description"></div>
                    </td>

                    <td>

                        {{ blog.category }}

                    </td>

                    <td>

                        {{ blog.created_by }}

                    </td>

                    <td>
                        <div class="date-range">
                            <span class="date">{{ blog.date_from }}</span>
                            <span class="arrow">→</span>
                            <span class="date">{{ blog.date_to }}</span>
                        </div>
                    </td>

                    <td>

                        <span class="status" :class="blog.status.toLowerCase()">

                            {{ blog.status }}

                        </span>

                    </td>

                    <td class="">

                        <button class="edit-btn" @click="editBlog(blog)">

                            Sửa

                        </button>


                    </td>


                </tr>

                <tr v-if="blogs.length == 0">

                    <td colspan="8" style="text-align:center">

                        Không có dữ liệu

                    </td>

                </tr>

            </tbody>

        </table>

        <!-- Pagination -->

        <div class="pagination" v-if="lastPage > 1">

            <button @click="changePage(currentPage - 1)" :disabled="currentPage == 1">
                << </button>

                    <button v-for="page in lastPage" :key="page" @click="changePage(page)" :class="{
                        active: currentPage == page
                    }">

                        {{ page }}

                    </button>

                    <button @click="changePage(currentPage + 1)" :disabled="currentPage == lastPage">

                        >>

                    </button>

        </div>

    </div>

</template>

<style scoped>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.blog-page {

    padding: 32px;
    background: #f1f5f9;
    min-height: 100vh;
    color: #0f172a;

}

.date-range {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    white-space: nowrap;
    font-size: 13px;
    color: #475569;
    font-weight: 500;
}

.date {
    padding: 4px 10px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
}

.arrow {
    color: #94a3b8;
    font-size: 16px;
    font-weight: bold;
}

/* HEADER */

.page-header {

    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 28px;

}


.page-header h1 {

    font-size: 28px;
    font-weight: 700;
    letter-spacing: -.5px;

}


.add-btn {

    background: #2563eb;
    color: white;

    border: none;
    border-radius: 8px;

    padding: 11px 18px;

    font-weight: 600;
    cursor: pointer;

    transition: .2s;

}


.add-btn:hover {

    background: #1d4ed8;

}


/* TOOLBAR */

.toolbar {

    background: white;

    padding: 20px;

    border-radius: 14px;

    display: flex;

    gap: 14px;

    margin-bottom: 20px;

    box-shadow: 0 1px 3px rgba(0, 0, 0, .05);

}


.input,
.select {

    height: 44px;

    border: 1px solid #e2e8f0;

    border-radius: 8px;

    padding: 0 14px;

    font-size: 14px;

    background: white;

    transition: .2s;

}


.input:focus,
.select:focus {

    outline: none;

    border-color: #2563eb;

    box-shadow: 0 0 0 3px rgba(37, 99, 235, .1);

}



/* TABLE CARD */

.table {

    width: 100%;

    border-collapse: separate;

    border-spacing: 0;

    background: white;

    border-radius: 14px;

    overflow: hidden;

    box-shadow:
        0 1px 3px rgba(0, 0, 0, .08);

}


.table th {

    background: #f8fafc;

    color: #475569;

    font-size: 13px;

    text-transform: uppercase;

    letter-spacing: .5px;

    padding: 16px;

    font-weight: 700;

}


.table td {

    padding: 16px;

    border-top: 1px solid #f1f5f9;

    font-size: 14px;

}


.table tbody tr {

    transition: .2s;

}


.table tbody tr:hover {

    background: #f8fafc;

}



/* IMAGE */

.thumb {

    width: 90px;

    height: 60px;

    object-fit: cover;

    border-radius: 8px;

}



/* TITLE */

.table strong {

    font-size: 15px;

    color: #0f172a;

}


.description {

    margin-top: 6px;

    color: #64748b;

    font-size: 13px;

    line-height: 1.5;

    max-width: 420px;


    display: -webkit-box;

    -webkit-line-clamp: 2;

    -webkit-box-orient: vertical;

    overflow: hidden;

}



/* STATUS */

.status {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    padding: 5px 12px;

    border-radius: 999px;

    font-size: 12px;

    font-weight: 600;

}


.status.draft {

    background: #fef3c7;

    color: #92400e;

}


.status.published {

    background: #dcfce7;

    color: #166534;

}


.status.archived {

    background: #e2e8f0;

    color: #475569;

}



/* ACTION */

.action-buttons {

    display: flex;

    gap: 8px;

}


.edit-btn,
.delete-btn {


    border: none;

    padding: 8px 14px;

    border-radius: 7px;

    font-size: 13px;

    font-weight: 600;

    cursor: pointer;

    transition: .2s;

}


.edit-btn {

    background: #eff6ff;

    color: #2563eb;

}


.edit-btn:hover {

    background: #dbeafe;

}



.delete-btn {

    background: #fee2e2;

    color: #dc2626;

}


.delete-btn:hover {

    background: #fecaca;

}



/* PAGINATION */

.pagination {

    display: flex;

    justify-content: center;

    gap: 8px;

    margin-top: 25px;

}



.pagination button {


    width: 36px;

    height: 36px;

    border: none;

    border-radius: 8px;

    background: white;

    cursor: pointer;

    font-weight: 600;

    color: #475569;

}


.pagination button:hover {

    background: #f1f5f9;

}


.pagination button.active {

    background: #2563eb;

    color: white;

}


.pagination button:disabled {

    opacity: .4;

}


/* LOADING */

.loading {

    background: white;

    padding: 40px;

    text-align: center;

    border-radius: 14px;

    color: #64748b;

}



/* MOBILE */

@media(max-width:992px) {


    .blog-page {

        padding: 16px;

    }


    .page-header {

        flex-direction: column;

        align-items: flex-start;

        gap: 15px;

    }


    .toolbar {

        flex-direction: column;

    }


    .table {

        display: block;

        overflow-x: auto;

    }


}
</style>