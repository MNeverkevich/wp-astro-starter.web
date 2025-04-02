import 'dotenv/config';

const BASE_URL = process.env.SITE_DOMAIN;
const WP_REST_URL_PREFIX = process.env.WP_REST_URL_PREFIX;

async function fetchApi(endpoint, params = {}) {
  try {
    const queryString = new URLSearchParams(params).toString();
    const url = `${BASE_URL}${endpoint}${queryString ? `?${queryString}` : ''}`;
    const response = await fetch(url);

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    return await response.json();
  } catch (error) {
    console.error(`Error fetching ${endpoint}:`, error);
    throw error;
  }
}

export async function getPost(slug) {
  return fetchApi(`/${WP_REST_URL_PREFIX}/wp/v2/posts`, { slug, _embed: true });
}

export async function getPosts(per_page = 10, offset = 0) {
  return fetchApi(`/${WP_REST_URL_PREFIX}/wp/v2/posts`, { per_page, offset });
}

export async function getAllPosts() {
  const postsPerPage = 100;
  let allPosts = [];
  let offset = 0;
  let hasMore = true;

  while (hasMore) {
    const posts = await getPosts(postsPerPage, offset);

    if (posts.length === 0) {
      hasMore = false;
    } else {
      allPosts = [...allPosts, ...posts];
      offset += postsPerPage;
    }
  }

  return allPosts;
}

export async function getHomePageData() {
  return fetchApi(`/${WP_REST_URL_PREFIX}/wp/v2/home_page`);
}

export async function getPage(slug) {
  return fetchApi(`/${WP_REST_URL_PREFIX}/wp/v2/pages`, { slug });
}

export async function getHomePage() {
  const homePageData = await getHomePageData();
  return fetchApi(`/${WP_REST_URL_PREFIX}/wp/v2/pages`, { slug: homePageData.slug });
}

export async function getPages() {
  return fetchApi(`/${WP_REST_URL_PREFIX}/wp/v2/pages`);
}

export async function primaryMenu() {
  return fetchApi(`/${WP_REST_URL_PREFIX}/wp/v2/menus/primary-menu`);
}

export async function footerMenu() {
  return fetchApi(`/${WP_REST_URL_PREFIX}/wp/v2/menus/footer-menu`);
}

export async function getCategory(id) {
  return fetchApi(`/${WP_REST_URL_PREFIX}/wp/v2/categories/` + id);
}

export async function getOptionsInfo() {
  return fetchApi(`/${WP_REST_URL_PREFIX}/acf/v3/options/options/`);
}