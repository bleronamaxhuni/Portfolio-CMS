const LEVEL_MAP = {
    beginner: 25,
    junior: 35,
    intermediate: 55,
    mid: 55,
    advanced: 75,
    senior: 85,
    expert: 95,
    master: 100,
}

export function proficiencyPercent(level) {
    if (!level) return 60

    const numeric = parseInt(String(level).replace(/%/g, ''), 10)
    if (!Number.isNaN(numeric) && numeric >= 0 && numeric <= 100) {
        return numeric
    }

    const key = String(level).trim().toLowerCase()
    return LEVEL_MAP[key] ?? 60
}
