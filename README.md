<h1 align="center">Công cụ mở khóa Apple ID bằng một cú nhấp chuột</h1>
<p căn chỉnh="trung tâm">
    <a href="https://github.com/pplulee/appleid_auto/issues" style="text-decoration:none">
        <img src="https://img.shields.io/github/issues/pplulee/appleid_auto.svg" alt="Sự cố GitHub"/>
    </a>
    <a href="https://github.com/pplulee/appleid_auto/stargazers" style="text-decoration:none" >
        <img src="https://img.shields.io/github/stars/pplulee/appleid_auto.svg" alt="GitHub sao"/>
    </a>
    <a href="https://github.com/pplulee/appleid_auto/network" style="text-decoration:none" >
        <img src="https://img.shields.io/github/forks/pplulee/appleid_auto.svg" alt="GitHub forks"/>
    </a>
    <a href="https://github.com/pplulee/apple_auto/blob/main/LICENSE" style="text-decoration:none" >
        <img src="https://img.shields.io/github/license/pplulee/appleid_auto" alt="Giấy phép GitHub"/>
    </a>
</p>
<h3 align="center"><a href="README_zh_CN.md" style="text-decoration:none">中文文档</a> | Tiếng Anh</h3>
<h3 align="center">Làm theo hướng dẫn bên dưới để có trải nghiệm tốt hơn</h3>  
<h3 align="center">Dự án của chúng tôi là nguồn mở và sẽ được cập nhật theo thời gian</h3>


# Giới thiệu cơ bản

"Quản lý ID Apple của bạn theo cách hoàn toàn mới" - Đây là chương trình phát hiện & mở khóa Apple ID tự động dựa trên các câu hỏi bảo mật.

Giao diện người dùng được sử dụng để quản lý tài khoản, hỗ trợ thêm nhiều tài khoản và cung cấp trang tài khoản hiển thị.

Tạo một trang được chia sẻ chứa nhiều tài khoản và đặt mật khẩu cho trang được chia sẻ. (Tùy chọn)

Phần phụ trợ thường xuyên kiểm tra xem tài khoản có bị khóa hay không. Nếu nó bị khóa hoặc bật 2FA, nó sẽ tự động được mở khóa, mật khẩu sẽ được thay đổi và mật khẩu sẽ được báo cáo cho API.

Đăng nhập Apple ID và tự động xóa thiết bị trong Apple ID.

Kích hoạt nhóm proxy và cụm Selenium để cải thiện tỷ lệ thành công và ngăn ngừa kiểm soát rủi ro. (Tùy chọn)


### Lời nhắc nhở:

1. **backend chạy dựa trên docker**, vui lòng đảm bảo rằng docker đã được cài đặt trên máy;
2. unblocker_manager là **chương trình quản lý phụ trợ**,
sẽ nhận danh sách tác vụ từ API theo định kỳ và triển khai các bộ chứa docker (một bộ chứa cho mỗi tài khoản);
3. Chương trình **cần sử dụng Chrome webdriver**,
nên sử dụng phiên bản Docker [selenium/standalone-chrome](https://hub.docker.com/r/selenium/standalone-chrome),
lệnh triển khai docker như sau, vui lòng sửa đổi các tham số theo nhu cầu của bạn. (Chỉ hỗ trợ x86_64,
nếu bạn đang sử dụng ARM, hãy thử [seleniarm/standalone-chromium](https://hub.docker.com/r/seleniarm/standalone-chromium) hoặc sử dụng lưới cụm: [sahuidhsu/selenium-grid-docker](https: //github.com/sahuidhsu/selenium-grid-docker))
```bash
docker run -d --name=webdriver --log-opt max-size=1m --log-opt max-file=1 --shm-size="2g" --restart=always -e SE_NODE_MAX_SESSIONS=10 -e SE_NODE_OVERRIDE_MAX_SESSIONS=true -e SE_SESSION_RETRY_INTERVAL=1 -e SE_VNC_VIEW_ONLY=1 -p 4444:4444 -p 5900:5900 selen/độc lập-chrome
```
4. Chương trình **backend** hiện hỗ trợ 3 ngôn ngữ: tiếng Anh, tiếng Hoa giản thể và tiếng Việt.
Có thể dễ dàng đặt ngôn ngữ bằng cách sử dụng tập lệnh triển khai bằng một cú nhấp chuột được cung cấp trong phần [Cách sử dụng](#Cách sử dụng).


# Cách sử dụng

**Vui lòng triển khai giao diện người dùng trước, sau đó cài đặt phần phụ trợ. Tập lệnh cài đặt phụ trợ cung cấp cài đặt webdriver chỉ bằng một cú nhấp chuột** \
Nếu bạn muốn biết thêm về cụm Lưới Selenium, vui lòng truy cập [sahuidhsu/selenium-grid-docker](https://github.com/sahuidhsu/selenium-grid-docker) \
Môi trường chạy trang web được đề xuất là php7.4 & MySQL8.0, về mặt lý thuyết hỗ trợ MySQL5.x, các phiên bản php khác có thể không được hỗ trợ.

1. Tải xuống mã nguồn trang web từ Bản phát hành và triển khai nó, nhập cơ sở dữ liệu (`sql/db.sql`), sao chép tệp cấu hình `config.bak.php` sang `config.php` và điền vào cài đặt \
   Tài khoản mặc định: `admin` mật khẩu: `admin`
2. Sau khi đăng nhập vào trang web, hãy thêm tài khoản Apple và điền thông tin tài khoản
3. Triển khai `backend\unblocker_manager.py` (chúng tôi cung cấp tập lệnh triển khai bằng một cú nhấp chuột, vui lòng xem bên dưới)
4. Kiểm tra xem `unblocker_manager` có lấy được danh sách tác vụ thành công hay không
5. Kiểm tra xem container đã được triển khai và chạy bình thường chưa

### Triển khai bằng một cú nhấp chuột của unblocker_manager (phụ trợ + webdriver):

```bash
bash <(curl -Ls https://raw.githubusercontent.com/pplulee/appleid_auto/main/backend/install_unblocker.sh)
```

### Mô tả câu hỏi bảo mật:

Các câu hỏi chỉ cần điền từ khóa, chẳng hạn như "sinh nhật", "công việc", v.v., nhưng vui lòng lưu ý **ngôn ngữ** của câu hỏi bảo mật tài khoản.


# Cập nhật giao diện người dùng

Tải xuống mã nguồn trang web từ Bản phát hành và ghi đè lên các tệp gốc, điền lại config.php và nhập tệp cơ sở dữ liệu đã cập nhật (tệp bắt đầu bằng update_).


# cập nhật phụ trợ

Nếu bạn đang sử dụng phiên bản mới nhất của tập lệnh quản lý phụ trợ, chỉ cần khởi động lại dịch vụ appleauto để cập nhật. Nếu không hoạt động, hãy chạy lại tập lệnh cài đặt.


# Phản hồi và Truyền thông

Chúng tôi không chuyên nghiệp, vì vậy như chương trình. Các vấn đề và Yêu cầu kéo đều được hoan nghênh và chúng tôi rất mong nhận được sự đóng góp của bạn! \
Nhóm Telegram: [@appleunblocker](https://t.me/appleunblocker)


# Mô tả tập tin

- `backend\unblocker_manager.py` Chương trình quản lý phụ trợ \
  **Mô tả**: Thường xuyên tìm nạp danh sách tác vụ từ API và triển khai bộ chứa docker tương ứng với tác vụ \
  **Thông số khởi chạy**: `-api_url <địa chỉ API> -api_key <khóa API> -lang <1/2/3> ` (Địa chỉ API phải ở định dạng `http(s)://xxx. xxx`, không bao giờ bao gồm `/` hoặc đường dẫn ở cuối.
  lang: 1 - Tiếng Trung giản thể, 2 - Tiếng Anh, 3 - Tiếng Việt)
- `backend\unlocker\main.py` Chương trình mở khóa backend \
  **Mô tả**: Mở khóa tài khoản bằng cách thay đổi mật khẩu thông qua Webdriver và trả lại mật khẩu mới cho API. **Chương trình này phụ thuộc vào API để chạy** \
  **Thông số khởi chạy**: `-api_url <API地址> -api_key <API key> -taskid <Task ID> -lang <zh_cn/en_us/vi_vn>`

**Chương trình quản lý phụ trợ** chỉ là chương trình cần thiết để chạy, chương trình này sẽ tự động nhận tác vụ từ trang API và triển khai bộ chứa docker. Thời gian đồng bộ hóa mặc định là 10 phút (khởi động lại dịch vụ để đồng bộ hóa thủ công) \
Nếu bạn chỉ muốn sử dụng **chương trình mở khóa phụ trợ**, vui lòng sử dụng phiên bản docker [sahuidhsu/appleid_auto](https://hub.docker.com/r/sahuidhsu/appleid_auto)

---
# Mua cho tôi một ly cà phê
[![ko-fi](https://ko-fi.com/img/githubbutton_sm.svg)](https://ko-fi.com/baiyimiao) \
USDT-TRC20: TV1su1RnQny27YEF9WG4DbC8AAz3udt6d4 \
ETH-ERC20：0xea8fbe1559b1eb4b526c3bb69285203969b774c5 \
[AD] Nếu bạn có nhu cầu sử dụng hộp thư, vui lòng tham khảo [nhà phát triển](https://t.me/baiyimiao) (Telegram)

---

# Tài liệu API

Đường dẫn: `/api/` \
Phương thức: `GET` \
Tất cả các hành động cần chuyển tham số `key`, là đối số `apikey` trong `config.php` \
Kiểu trả về: `JSON` \
Thông số trả về chung

| thông số | giá trị/loại | mô tả |
|------------|-------------------|------------------ --------|
| `trạng thái` | `thành công`/`thất bại` | hoạt động thành công / thất bại |
| `tin nhắn` | `Chuỗi` | thông tin nhanh chóng |

Hành động: `random_sharepage_password` \
Mô tả: Tạo mật khẩu trang chia sẻ ngẫu nhiên \
Thông số đầu vào:

| thông số | giá trị/loại | mô tả |
|--------|------------------------|------- --------|
| `hành động` | `ngẫu nhiên_sharepage_mật khẩu` | hoạt động |
| `id` | `int` | chia sẻ ID trang |

tham số trả về:

| thông số | giá trị/loại | mô tả |
|------------|--------------|--------------|
| `mật khẩu` | `Chuỗi` | mật khẩu mới |

……Những người còn lại đang chờ được bổ sung (๑•̀ㅂ•́)و✧

---

# Giao diện API JSON

Có thể lấy thông tin tài khoản ở định dạng JSON bằng cách chia sẻ liên kết trang, liên kết này có thể được sử dụng để tích hợp với các ứng dụng khác. \
Liên kết trang đề cập đến mã của trang chứ không phải toàn bộ URL.

Địa chỉ API: `/api/share.php` \
Phương thức yêu cầu: `GET` \
Thông số đầu vào:

| thông số | giá trị/loại | mô tả |
|--------------|--------------|------------------- -|
| `liên_kết_chia_sẻ` | `Chuỗi` | 分享页代码 |
| `mật khẩu` | `Chuỗi` | 分享页密码（若未设置密码则不需要） |

tham số trả về:

| thông số | giá trị/loại | mô tả |
|---------------------|------------------|---------------- ------------------------------------|
| `trạng thái` | `thành công`/`thất bại` | hoạt động thành công / thất bại |
| `tin nhắn` | `Chuỗi` | thông tin nhanh chóng |
| `tài khoản` | `Mảng` | Danh sách thông tin tài khoản (xem bảng bên dưới) |

Thông tin tài khoản:

| thông số | giá trị/loại | mô tả |
|---------------------|------------------|------------------ ---------|
| `id` | `int` | ID tài khoản |
| `tên người dùng` | `Chuỗi` | Tài khoản |
| `mật khẩu` | `Chuỗi` | Mật khẩu |
| `trạng thái` | `Bool` | Trạng thái tài khoản |
| `kiểm tra lần cuối` | `Chuỗi` | Lần kiểm tra cuối cùng |
| `nhận xét` | `Chuỗi` | Nhận xét về mặt trước của tài khoản |


---
# Những việc cần làm

- [x] Tự động nhận dạng mã xác minh
- [x] Kiểm tra xem tài khoản có bị khóa không
- [x] Kiểm tra trạng thái 2FA
- [x] Thêm hỗ trợ cho nhiều tài khoản trong trang chia sẻ
- [x] Thêm hạn chế chia sẻ trang (bảo vệ bằng mật khẩu)
- [x] Kiểm tra mật khẩu
- [x] Xóa thiết bị
- [x] Thay đổi mật khẩu định kỳ
- [x] Khai báo mật khẩu
- [x] Nhóm proxy
- [x] Thông báo Bot Telegram
- [x] Giao diện API JSON để lấy thông tin tài khoản
