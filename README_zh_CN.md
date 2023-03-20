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
<h3 align="center">Tài liệu tiếng Trung | <a href="README.md">Tiếng Anh</a> </h3>
<h3 align="center">Vui lòng đọc kỹ tài liệu này và các tài liệu Wiki mà chúng tôi sẽ phát hành trong tương lai trước khi sử dụng. </h3>  
<h3 align="center">Dự án này vẫn đang được cập nhật. </h3>

#giới thiệu cơ bản

"Quản lý ID Apple của bạn theo cách mới" - đây là chương trình phát hiện & mở khóa Apple ID tự động dựa trên các câu hỏi bảo mật mật khẩu.

Giao diện người dùng được sử dụng để quản lý tài khoản, hỗ trợ thêm nhiều tài khoản và cung cấp trang tài khoản hiển thị;

Hỗ trợ tạo trang chia sẻ với nhiều tài khoản, có thể đặt mật khẩu cho trang chia sẻ.

Chương trình phụ trợ thường xuyên phát hiện xem tài khoản có bị khóa hay không. Nếu tài khoản bị khóa hoặc xác minh hai bước được bật, tài khoản sẽ tự động được mở khóa, mật khẩu sẽ được thay đổi và mật khẩu sẽ được báo cáo cho API.

Đăng nhập vào ID Apple của bạn và tự động xóa thiết bị khỏi ID Apple của bạn.

Kích hoạt nhóm proxy và cụm Selenium để tăng tỷ lệ mở khóa thành công và ngăn ngừa kiểm soát rủi ro.

### Các biện pháp phòng ngừa:

1. Hiện tại **backend chạy dựa trên docker**, vui lòng đảm bảo máy đã cài đặt docker;
2. unblocker_manager là một **chương trình quản lý back-end**, chương trình này sẽ thường xuyên lấy danh sách tác vụ từ API và triển khai các bộ chứa docker (mỗi tài khoản tương ứng với một bộ chứa);
3. Chương trình **cần sử dụng Chrome webdriver**
   , bạn nên sử dụng phiên bản Docker [selenium/standalone-chrome](https://hub.docker.com/r/selenium/standalone-chrome)
   , hướng dẫn triển khai docker như sau, vui lòng sửa đổi các tham số theo nhu cầu của bạn. (chỉ hỗ trợ x86_64, nếu bạn có yêu cầu về ARM
   , hãy thử [seleniarm/standalone-chromium](https://hub.docker.com/r/seleniarm/standalone-chromium) hoặc sử dụng cụm docker: [sahuidhsu/selenium-grid-docker](https://github. com/sahuidhsu/selenium-grid-docker))
```bash
docker run -d --name=webdriver --log-opt max-size=1m --log-opt max-file=1 --shm-size="2g" --restart=always -e SE_NODE_MAX_SESSIONS=10 -e SE_NODE_OVERRIDE_MAX_SESSIONS=true -e SE_SESSION_RETRY_INTERVAL=1 -e SE_VNC_VIEW_ONLY=1 -p 4444:4444 -p 5900:5900 selen/độc lập-chrome
```
4. **Đầu ra phụ trợ** của chương trình hiện hỗ trợ ba ngôn ngữ: Tiếng Trung giản thể/Tiếng Anh/Tiếng Việt. Bạn có thể dễ dàng chọn ngôn ngữ triển khai thông qua tập lệnh triển khai bằng một cú nhấp chuột trong [Phương thức sử dụng](#Phương thức sử dụng).


# Hướng dẫn

** Vui lòng triển khai giao diện người dùng trước, sau đó cài đặt giao diện người dùng phía sau. Tập lệnh cài đặt phụ trợ cung cấp cài đặt webdriver chỉ bằng một cú nhấp chuột** \
Nếu bạn muốn tìm hiểu về cụm Lưới Selenium, vui lòng truy cập [sahuidhsu/selenium-grid-docker](https://github.com/sahuidhsu/selenium-grid-docker)\
php7.4 & MySQL8.0 được khuyến nghị cho môi trường đang chạy của trang web, MySQL5.x được hỗ trợ về mặt lý thuyết và các phiên bản php khác có thể không được hỗ trợ.

1. Tải xuống mã nguồn của trang web từ Bản phát hành và triển khai nó, nhập cơ sở dữ liệu (`sql/db.sql`), sao chép tệp cấu hình `config.bak.php` sang `config.php` và điền vào mục cài đặt \
   Tài khoản mặc định: `admin` Mật khẩu: `admin`
2. Sau khi đăng nhập website, thêm tài khoản Apple và điền thông tin tài khoản
3. Triển khai `backend\unblocker_manager.py` (cung cấp tập lệnh triển khai bằng một cú nhấp chuột, xem bên dưới)
4. Kiểm tra xem `unblocker_manager` đã lấy thành công danh sách nhiệm vụ chưa
5. Kiểm tra xem container đã được triển khai và chạy bình thường chưa

### [Khuyến nghị] Triển khai unblocker_manager bằng một cú nhấp chuột (phụ trợ + trình điều khiển web):
```bash
bash <(curl -Ls https://raw.githubusercontent.com/pplulee/appleid_auto/main/backend/install_unblocker.sh)
```

### Giải thích về các vấn đề bảo mật:

Trong cột câu hỏi, bạn chỉ cần điền các từ khóa, chẳng hạn như "sinh nhật", "công việc", v.v., nhưng hãy chú ý đến **ngôn ngữ** của câu hỏi bảo mật tài khoản

# Cập nhật giao diện người dùng

Tải xuống mã nguồn của trang web từ Bản phát hành và ghi đè lên tệp gốc, điền lại config.php và nhập tệp cơ sở dữ liệu đã cập nhật (tệp bắt đầu bằng update_).

# cập nhật phụ trợ

Nếu đó là phiên bản mới nhất của tập lệnh quản lý back-end, chỉ cần khởi động lại dịch vụ appleauto. Nếu không thể cập nhật, bạn có thể thực hiện lại tập lệnh cài đặt

# Câu Hỏi Phản Hồi & Truyền Thông

Trình độ và khả năng của nhà phát triển có hạn, và có thể có nhiều lỗi trong chương trình. Các vấn đề hoặc Yêu cầu kéo đều được hoan nghênh và mọi người đều được hoan nghênh tham gia dự án! \
Telegram群：[@appleunblocker](https://t.me/appleunblocker)

# tập tin đặc tả

- `backend\unblocker_manager.py` trình quản lý phụ trợ \
  Mô tả: Dùng để thường xuyên lấy task list từ API và triển khai docker container tương ứng với task \
  Tham số khởi động: `-api_url <địa chỉ API> -api_key <khóa API>` (định dạng của địa chỉ API là `http(s)://xxx.xxx` và không cần thêm `/` hoặc đường dẫn tại kết thúc)
- `backend\unlocker\main.py` trình mở khóa phụ trợ \
  Mô tả: Thay đổi và mở khóa tài khoản thông qua Webdriver, đồng thời gửi mật khẩu mới cho API. **Chương trình này dựa vào API để chạy** \
  Tham số bắt đầu: `-api_url <địa chỉ API> -api_key <khóa API> -taskid <ID tác vụ>`

Chỉ cần triển khai **chương trình quản lý backend**, script sẽ tự động nhận tác vụ từ site API và triển khai container, thời gian đồng bộ mặc định là 10 phút (khởi động lại dịch vụ để đồng bộ ngay) \
Nếu không muốn sử dụng đồng bộ hóa tự động, bạn cũng có thể triển khai trực tiếp **Trình mở khóa phụ trợ**, phiên bản docker [sahuidhsu/appleid_auto](https://hub.docker.com/r/sahuidhsu/appleid_auto)

---
# mua cho tôi một lon coca
[![ko-fi](https://ko-fi.com/img/githubbutton_sm.svg)](https://ko-fi.com/baiyimiao) \
USDT-TRC20: TV1su1RnQny27YEF9WG4DbC8AAz3udt6d4 \
ETH-ERC20：0xea8fbe1559b1eb4b526c3bb69285203969b774c5 \
[Quảng cáo] Nếu bạn cần sử dụng bưu điện, vui lòng tham khảo [Nhà phát triển](https://t.me/baiyimiao) (Telegram)

---

# Mô tả API

Đường dẫn: `/api/` \
Phương thức: `GET` \
Tất cả các hành động cần chuyển tham số `key`, giá trị là `apikey` trong `config.php` \
Kiểu trả về: `JSON`\
Tham số trả về chung

|Tham số |Giá trị/Loại |Mô tả |
|-----------|------------------|---------|
| `trạng thái` | `thành công`/`thất bại` | thao tác thành công/thất bại |
|`thông báo`|`Chuỗi`|thông báo nhắc nhở|

Hành động: `random_sharepage_password` \
Mô tả: Tạo mật khẩu trang chia sẻ ngẫu nhiên \
Thông số đầu vào:

|Tham số |Giá trị/Loại |Mô tả |
|----------|-----------------------------|-------|
|`hành động` |`ngẫu nhiên_sharepage_password` |
|`id`|`Int`|ID trang chia sẻ|

Tham số trả về:

|Tham số |Giá trị/Loại |Mô tả |
|------------|----------|-----|
|`mật khẩu`|`Chuỗi`|mật khẩu mới|

...phần còn lại đang chờ được thêm vào

---

# Giao diện API JSON

Hỗ trợ lấy thông tin tài khoản ở dạng JSON bằng cách chia sẻ liên kết trang, để kết nối với các Ứng dụng khác \
Liên kết trang được chia sẻ đề cập đến mã của trang, không phải toàn bộ URL

Địa chỉ API: `/api/share.php` \
Phương thức yêu cầu: `GET` \
Thông số đầu vào:

|Tham số |Giá trị/Loại |Mô tả |
|--------------|----------|-------------------|
|`share_link`|`String`|chia sẻ mã trang|
|`password`|`String`|Mật khẩu của trang chia sẻ (không bắt buộc nếu chưa đặt mật khẩu) |

Tham số trả về:

|Tham số |Giá trị/Loại |Mô tả |
|------------|------------------|---------------|
| `trạng thái` | `thành công`/`thất bại` | thao tác thành công/thất bại |
|`thông báo`|`Chuỗi`|thông báo nhắc nhở|
|`accounts`|`Array`|danh sách thông tin tài khoản (xem bảng bên dưới) |

thông tin tài khoản:

|Tham số |Giá trị/Loại |Mô tả |
|--------------|----------|--------|
|`id` |`Int` |ID tài khoản|
|`tên người dùng`|`Chuỗi`|số tài khoản|
|`mật khẩu`|`Chuỗi`|mật khẩu|
|`trạng thái` |`Bool`|trạng thái tài khoản|
|`last_check` |`String` | thời gian kiểm tra lần cuối |
| `nhận xét` | `Chuỗi` | nhận xét về giao diện người dùng của tài khoản |


---
# Những việc cần làm

- [x] Mã xác minh tự động nhận dạng
- [x] Phát hiện tài khoản bị khóa
- [x] Phát hiện 2FA
- [x] Trang chia sẻ hỗ trợ nhiều tài khoản
- [x] trang chia sẻ có thể mở mật khẩu
- [x] Kiểm tra mật khẩu có đúng không
- [x] xóa thiết bị
- [x] Thay đổi mật khẩu thường xuyên
- [x] khai báo mật khẩu
- [x] nhóm proxy
- [x] Thông báo bot Telegram
- [x] Giao diện API JSON để lấy thông tin tài khoản
- [x] Phần phụ trợ hỗ trợ lấy proxy từ giao diện API
- [ ] trang chia sẻ hỗ trợ thời hạn hiệu lực
