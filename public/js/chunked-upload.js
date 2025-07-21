// public/js/chunked-upload.js
class ChunkedUpload {
    constructor(file, options = {}) {
        this.file = file;
        this.chunkSize = options.chunkSize || 5 * 1024 * 1024; // 5MB chunks
        this.chunks = Math.ceil(this.file.size / this.chunkSize);
        this.currentChunk = 0;
        this.uploadUrl = options.uploadUrl || '/admin/videos/upload-chunk';
        this.completeUrl = options.completeUrl || '/admin/videos/complete-upload';
        this.onProgress = options.onProgress || (() => {});
        this.onComplete = options.onComplete || (() => {});
        this.onError = options.onError || (() => {});
        this.uploadId = this.generateUploadId();
    }

    generateUploadId() {
        return Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    }

    async start() {
        try {
            for (let i = 0; i < this.chunks; i++) {
                await this.uploadChunk(i);
            }
            await this.completeUpload();
        } catch (error) {
            this.onError(error);
        }
    }

    async uploadChunk(chunkIndex) {
        const start = chunkIndex * this.chunkSize;
        const end = Math.min(start + this.chunkSize, this.file.size);
        const chunk = this.file.slice(start, end);

        const formData = new FormData();
        formData.append('chunk', chunk);
        formData.append('chunkIndex', chunkIndex);
        formData.append('totalChunks', this.chunks);
        formData.append('uploadId', this.uploadId);
        formData.append('fileName', this.file.name);

        const response = await fetch(this.uploadUrl, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        if (!response.ok) {
            throw new Error(`Chunk ${chunkIndex} upload failed`);
        }

        this.currentChunk = chunkIndex + 1;
        const progress = (this.currentChunk / this.chunks) * 100;
        this.onProgress(progress);
    }

    async completeUpload() {
        const response = await fetch(this.completeUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                uploadId: this.uploadId,
                fileName: this.file.name,
                totalChunks: this.chunks
            })
        });

        if (!response.ok) {
            throw new Error('Failed to complete upload');
        }

        const data = await response.json();
        this.onComplete(data);
    }
}