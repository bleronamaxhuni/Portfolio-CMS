export function resolveProfileImage(about) {
  if (!about) return null

  if (about.profile_img_url) {
    return about.profile_img_url
  }

  if (about.profile_image_data && about.profile_image_mime) {
    return `data:${about.profile_image_mime};base64,${about.profile_image_data}`
  }

  const path = about.profile_img || about.profile_image
  if (!path) return null

  if (/^(https?:|data:)/i.test(path)) {
    return path
  }

  return path.startsWith('/') ? path : `/storage/${path.replace(/^\//, '')}`
}
