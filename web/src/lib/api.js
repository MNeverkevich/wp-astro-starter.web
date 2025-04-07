import 'dotenv/config';

const BASE_URL = process.env.SITE_DOMAIN;
const WP_REST_URL_PREFIX = process.env.WP_REST_URL_PREFIX;
const WP_ADMIN_LOGIN = process.env.WP_ADMIN_LOGIN;
const WP_ADMIN_APPLICATION_PASSWORD = process.env.WP_ADMIN_APPLICATION_PASSWORD;
const WP_MODE = process.env.WP_MODE;

async function fetchApi(endpoint, params = {}, headers = {}) {
  try {
    const queryString = new URLSearchParams(params).toString();
    const url = `${BASE_URL}${endpoint}${queryString ? `?${queryString}` : ''}`;
    const response = await fetch(url, headers);

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

export async function getPosts(attributes = {}) {
  return fetchApi(`/${WP_REST_URL_PREFIX}/wp/v2/posts`, attributes);
}

export async function getAllPosts() {
  const postsPerPage = 9;
  let allPosts = [];
  let offset = 0;
  let hasMore = true;

  while (hasMore) {
    const posts = await getPosts({
      per_page: postsPerPage,
      offset,
      _embed: true,
    });

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

export async function getDraftPages() {
  const headers = WP_MODE !== 'PROD' ? {
    headers: {
      'Authorization': 'Basic ' + btoa(WP_ADMIN_LOGIN + ':' + WP_ADMIN_APPLICATION_PASSWORD),
      'Content-Type': 'application/json'
    }
  } : {};
  return fetchApi(`/${WP_REST_URL_PREFIX}/wp/v2/pages`, { status: 'draft' }, headers);
}
