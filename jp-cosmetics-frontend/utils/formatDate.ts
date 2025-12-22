export function formatDate(isoString: string, locale: string = "en-US"): string {
  if (!isoString) return "";

  const date = new Date(isoString);

  return date.toLocaleDateString(locale, {
    year: "numeric",
    month: "short",
    day: "numeric",
  });
}
