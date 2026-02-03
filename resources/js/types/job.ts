export type Job = {
    data: {
        title: string,
        description: string,
        employer: string,
        location: string,
        min_salary: string,
        max_salary: string,
        posted_at: string
    }
}

export type JobItem = {
    data: {
        title: string,
        location: string,
        posted_at: string
    }
}
